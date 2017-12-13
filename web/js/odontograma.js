jQuery(function(){

	function drawDiente(svg, parentGroup, diente){
		if(!diente) throw new Error('Error no se ha especificado el diente.');
		
		var x = diente.x || 0,
			y = diente.y || 0;

		//Busco los tratamientos aplicados al diente
		var tratamientosAplicadosAlDiente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.diente.id == diente.id;
		});	
		
		var defaultPolygon = {fill: 'white', stroke: 'navy', strokeWidth: 0.5};
		var dienteGroup = svg.group(parentGroup, {transform: 'translate(' + x + ',' + y + ')'});

		var caraSuperior = svg.polygon(dienteGroup,
			[[0,0],[20,0],[15,5],[5,5]],  
		    defaultPolygon);
	    caraSuperior = $(caraSuperior).data('cara', 'S');
		
		var caraInferior =  svg.polygon(dienteGroup,
			[[5,15],[15,15],[20,20],[0,20]],  
		    defaultPolygon);			
		caraInferior = $(caraInferior).data('cara', 'I');

		var caraDerecha = svg.polygon(dienteGroup,
			[[15,5],[20,0],[20,20],[15,15]],  
		    defaultPolygon);
	    caraDerecha = $(caraDerecha).data('cara', 'D');
		
		var caraIzquierda = svg.polygon(dienteGroup,
			[[0,0],[5,5],[5,15],[0,20]],  
		    defaultPolygon);
		caraIzquierda = $(caraIzquierda).data('cara', 'Z');		    
		
		var caraCentral = svg.polygon(dienteGroup,
			[[5,5],[15,5],[15,15],[5,15]],  
		    defaultPolygon);	
		caraCentral = $(caraCentral).data('cara', 'C');		    
	    
	    var caraCompleto = svg.text(dienteGroup, 6, 30, diente.id.toString(), 
	    	{fill: 'navy', stroke: 'navy', strokeWidth: 0.1, style: 'font-size: 6pt;font-weight:normal'});
    	caraCompleto = $(caraCompleto).data('cara', 'X');

        // Si el diente tiene una extraccion entre sus tratamientos agrego una cruz
      	if (esExtraccion(diente)[0] && !esImplante(diente)[0]){
    		
    		// Cambio color del poligono, en este caso pinta las extracciones
    		defaultPolygon = {fill: 'white', stroke: esExtraccion(diente)[1], strokeWidth: 1.5};

    		var caraSS = svg.polygon(dienteGroup,
				[[-2,-2],[5,5],[10,10],[22,22]],  
			    defaultPolygon);
		    caraSS = $(caraSS).data('cara', 'SS');
		
			var caraII =  svg.polygon(dienteGroup,
				[[22,-2],[15,5],[10,10],[-2,22]],  
			    defaultPolygon);			
			caraII = $(caraII).data('cara', 'II');
		};

		// Si el diente tiene una corona entre sus tratamientos agrego una circulo
      	if (esCorona(diente)[0]){
    		
    		var caraSS = svg.circle(dienteGroup, 10, 10, 10, {fill: 'none', stroke: esCorona(diente)[1], strokeWidth: 3});
		    caraSS = $(caraSS).data('cara', 'SS');

		};

		// Si es implanete, agrega Implante
      	if (esImplante(diente)[0]){ 
    		
    		var caraSS = svg.text(dienteGroup, 6, -2, 'IMPL', 
	    	{fill: esImplante(diente)[1], stroke: esImplante(diente)[1], strokeWidth: 0.1, style: 'font-size: 6pt;font-weight:normal'});
    	    caraCompleto = $(caraCompleto).data('cara', 'X');

    	    caraSS = $(caraSS).data('cara', 'SS');

		};		

		// Si el diente tiene Perno Muñon va PM
      	if (esPernomunion(diente)[0]){ 
    		
    		var caraSS = svg.text(dienteGroup, 6, -2, 'PM', 
	    	{fill: esPernomunion(diente)[1], stroke: esPernomunion(diente)[1], strokeWidth: 0.1, style: 'font-size: 6pt;font-weight:normal'});
    	    caraCompleto = $(caraCompleto).data('cara', 'X');

    	    caraSS = $(caraSS).data('cara', 'SS');

		};																																																																																																																																																																																																																																																																																																																																																				

		// Si el diente tiene tratamiento de conducto solamente va conducto.(pernomunion anula conducto)
      	if (esConducto(diente)[0] && !esPernomunion(diente)[0]){ 
    		
    		var caraSS = svg.text(dienteGroup, 6, -2, 'TC', 
	    	{fill: esConducto(diente)[1], stroke: esConducto(diente)[1], strokeWidth: 0.1, style: 'font-size: 6pt;font-weight:normal'});
    	    caraCompleto = $(caraCompleto).data('cara', 'X');

    	    caraSS = $(caraSS).data('cara', 'SS');

		};																																																																																																																																																																																																																																																																																																																																																				

		// Si el diente tiene radiografia y no tiene conducto ni pernomunion, va radiografia
      	if (esRadiografia(diente)[0] && !esConducto(diente)[0] && !esPernomunion(diente)[0]){
    		
    		var caraSS = svg.text(dienteGroup, 6, -2, 'RX', 
	    	{fill: esRadiografia(diente)[1], stroke: esRadiografia(diente)[1], strokeWidth: 0.1, style: 'font-size: 6pt;font-weight:normal'});
    	    caraCompleto = $(caraCompleto).data('cara', 'X');

    	    caraSS = $(caraSS).data('cara', 'SS');

		};

		// Si el diente tiene protesis fija a otro diente y esta completo
		var $es_protesisf=esProtesisf(diente);
		if ($es_protesisf[0] && $es_protesisf[4] && $es_protesisf[2]==diente.id){

			// Cambio color del poligono, en este caso pinta las extracciones
    		defaultPolygon = {fill: 'white', stroke: $es_protesisf[1], strokeWidth: 1.5};

    		var $dientei = $es_protesisf[2]; 
    		var $dientef = $es_protesisf[3];
    		var extrasize = 0;
            var $longitud = calcularDistanciaProtesisf($dientei, $dientef);

    		// cara superior
    		var caraSS = svg.polygon(dienteGroup,
				[[-2,-2],[$longitud, -2]],  
			    defaultPolygon);
		    caraSS = $(caraSS).data('cara', 'SS');

		    // cara inferior
		    var caraSS = svg.polygon(dienteGroup,
				[[-2,22],[$longitud, 22]],  
			    defaultPolygon);
		    caraSS = $(caraSS).data('cara', 'SS');
		
			// cara vertical izquierda
			var caraSS = svg.polygon(dienteGroup,
				[[-2,-2],[-2, 22]],  
			    defaultPolygon);
		    caraSS = $(caraSS).data('cara', 'SS');

		    // cara vertical derecha
			var caraSS = svg.polygon(dienteGroup,
				[[$longitud,-2],[$longitud, 22]],  
			    defaultPolygon);
		    caraSS = $(caraSS).data('cara', 'SS');
		};	
    	
		
		//console.log(JSON.stringify(tratamientosAplicadosAlDiente));
		//alert (JSON.stringify(tratamientosAplicadosAlDiente));
		var caras = [];
		caras['S'] = caraSuperior;
		caras['C'] = caraCentral;
		caras['X'] = caraCompleto;
		caras['Z'] = caraIzquierda;
		caras['D'] = caraDerecha;
		caras['I'] = caraInferior;
		
		/*for (var i = tratamientosAplicadosAlDiente.length - 1; i >= 0; i--) {
			var t = tratamientosAplicadosAlDiente[i];
			caras[t.cara].attr('fill', t.tratamiento.color);
		};*/

        // SOlo pinto si no es extraccion, corona, 
		if (!esExtraccion(diente)[0] && !esCorona(diente)[0]){
			for (var i = 0; i <= tratamientosAplicadosAlDiente.length - 1; i++) {
				var t = tratamientosAplicadosAlDiente[i];
				caras[t.cara].attr('fill', t.tratamiento.color);
			}
		};
	
		$.each([caraCentral, caraIzquierda, caraDerecha, caraInferior, caraSuperior, caraCompleto], function(index, value){
	    	value.click(function(){
	    		var me = $(this);
	    		var cara = me.data('cara');
				
				if(!vm.tratamientoSeleccionado()){
					//alert('Debe seleccionar un tratamiento previamente.');	
					tempAlert("Debe seleccionar un tratamiento previamente",2000,"red");
					return false;
				}

				//Validaciones
				//Validamos el tratamiento
				var t = vm.tratamientoSeleccionado();
				t.color = $("#selectedcolor").val();

				var tratamiento = jQuery.extend({}, t);

				if(cara == 'X' && !tratamiento.aplicaDiente){
					//alert('El tratamiento seleccionado no se puede aplicar a toda la pieza.');
					tempAlert("El tratamiento seleccionado no se puede aplicar a toda la pieza",2000,"red");
					return false;
				}
				if(cara != 'X' && !tratamiento.aplicaCara){
					tempAlert("El tratamiento seleccionado no se puede aplicar a una cara",2000,"red");
					//alert('El tratamiento seleccionado no se puede aplicar a una cara.');
					return false;
				}

				// Si es implante y no tiene extraccion previa no se puede agregar
				if (tratamiento.id=="01.04" && !esExtraccion(diente)[0]){ 
    		        //alert('El implamente necesita una extracción previa para poder aplicarse.');
    		        tempAlert("El implamente necesita una extracción previa para poder aplicarse",2000,"red");
					return false;
				};	

				// Si es implante y no tiene extraccion previa no se puede agregar
				if (tratamiento.id=="01.04" && !esExtraccion(diente)[0]){ 
    		        //alert('El implamente necesita una extracción previa para poder aplicarse.');
    		        tempAlert("El implamente necesita una extracción previa para poder aplicarse",2000,"red");
					return false;
				};	

				// Intenta actualizar protesis fija
				var agregar = true;
				var actualizarp = actualizarProtesisf(diente);

				// Si no pudo actualizar protesis fija por mala seleccion avisa de la mala seleccion
				if (tratamiento.id=="01.09" && actualizarp[0] && actualizarp[1]){ 
    		        //alert('El implamente necesita una extracción previa para poder aplicarse.');
    		        tempAlert("Hubo una mala selección de la Prótesis Fija",2000,"red");
					return false;
				};	

				if (tratamiento.id=="01.09" && actualizarp[0]){
                    agregar = false;
               }	

				// solo se agrega un puente si no hay uno abierto
                if (agregar) {
                    vm.tratamientosAplicados.unshift({diente: diente, cara: cara, tratamiento: tratamiento});
				}
				
				$('#jsonatenciones').val(JSON.stringify(vm.tratamientosAplicados()));
				
				// Limpie el array observable y lo cargue de nuevo porque no detecta los eventos la lista desplegable
				var jsonatenciones = JSON.parse($('#jsonatenciones').val());
				vm.tratamientosAplicados.removeAll();
			    for (var key in jsonatenciones) {
			     		vm.tratamientosAplicados.push({diente: jsonatenciones[key]["diente"], cara: jsonatenciones[key]["cara"], tratamiento: jsonatenciones[key]["tratamiento"]});
			    }
				
				
				//Actualizo el SVG
				renderSvg();
	    	}).mouseenter(function(){
	    		var me = $(this);
	    		me.data('oldFill', me.attr('fill'));
	    		me.attr('fill', 'yellow');
	    	}).mouseleave(function(){
	    		var me = $(this);
	    		me.attr('fill', me.data('oldFill'));
	    	});			
		});
	};

	function renderSvg(){
		console.log('update render');

		var svg = $('#odontograma').svg('get').clear();
		var parentGroup = svg.group({transform: 'scale(1.5)'});
		var dientes = vm.dientes();
		for (var i =  dientes.length - 1; i >= 0; i--) {
			var diente =  dientes[i];
			var dienteUnwrapped = ko.utils.unwrapObservable(diente); 
			drawDiente(svg, parentGroup, dienteUnwrapped);
		};
	}

/* AGREGADOS POR MI PARA DETECTAR TIPO DE TRATAMIENTO */
	function esExtraccion(diente){
		
		var esExt = false;
		var color = 'blue';

		var trat_apli_al_diente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.diente.id == diente.id;
		});	

     
		for (var i = 0; i <= trat_apli_al_diente.length - 1; i++) {
			var t = trat_apli_al_diente[i];
            
          	if (t.tratamiento.id == "01.02"){
			  esExt = true;
			  color = t.tratamiento.color;
          	}  
		};

        var salida=[esExt,color];
		return salida;
	}

	function esCorona(diente){
		
		var esCor = false;
		var color = 'blue';

		var trat_apli_al_diente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.diente.id == diente.id;
		});	

     
		for (var i = 0; i <= trat_apli_al_diente.length - 1; i++) {
			var t = trat_apli_al_diente[i];
            
          	if (t.tratamiento.id == "01.05"){
			  esCor = true;
			  color = t.tratamiento.color;
          	}  
		};

        var salida=[esCor,color];
		return salida;
	}

	function esRadiografia(diente){
		
		var esRad = false;
		var color = 'blue';

		var trat_apli_al_diente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.diente.id == diente.id;
		});	

     
		for (var i = 0; i <= trat_apli_al_diente.length - 1; i++) {
			var t = trat_apli_al_diente[i];
            
          	if (t.tratamiento.id == "01.07"){
			  esRad = true;
			  color = t.tratamiento.color;
          	}  
		};

        var salida=[esRad,color];
		return salida;
	}

	function esConducto(diente){
		
		var esCon = false;
		var color = 'blue';

		var trat_apli_al_diente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.diente.id == diente.id;
		});	

     
		for (var i = 0; i <= trat_apli_al_diente.length - 1; i++) {
			var t = trat_apli_al_diente[i];
            
          	if (t.tratamiento.id == "01.06"){
			  esCon = true;
			  color = t.tratamiento.color;
          	}  
		};

        var salida=[esCon,color];
		return salida;
	}

	function esPernomunion(diente){
		
		var esPer = false;
		var color = 'blue';

		var trat_apli_al_diente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.diente.id == diente.id;
		});	

     
		for (var i = 0; i <= trat_apli_al_diente.length - 1; i++) {
			var t = trat_apli_al_diente[i];
            
          	if (t.tratamiento.id == "01.08"){
			  esPer = true;
			  color = t.tratamiento.color;
          	}  
		};

        var salida=[esPer,color];
		return salida;
	}

	function esImplante(diente){
		
		var esImpl = false;
		var color = 'blue';

		var trat_apli_al_diente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.diente.id == diente.id;
		});	

     
		for (var i = 0; i <= trat_apli_al_diente.length - 1; i++) {
			var t = trat_apli_al_diente[i];
            
          	if (t.tratamiento.id == "01.04"){
			  esImpl = true;
			  color = t.tratamiento.color;
          	}  
		};

        var salida=[esImpl,color];
		return salida;
	}
 

    /*  PRINCIPIO LOGICA DE PROTESIS FIJA */
    // Controla si es puente y si esta completo (si tiene principio y fin)
	function esProtesisf(diente){
		
		var esProtesisf = false;
		var color = 'blue';
		var pdiente = ""; //primer diente
		var udiente = "";   // ultimo diente
		var protesisfcompleto = false;
		var salida ='';

		var esCor = false;
		var color = 'blue';

		var trat_protesisf = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.tratamiento.id == "01.09";
		});	

		try {

     	for (var i = 0; i <= trat_protesisf.length - 1; i++) {
			var t = trat_protesisf[i];
            
            // Si esta completo el puente
            if (t.diente.id.indexOf('_') > -1) { 
		       pdiente = t.diente.id.substring(0, t.diente.id.indexOf('_'));	
			   udiente = t.diente.id.substring(t.diente.id.lastIndexOf('_')+3, t.diente.id.length - t.diente.id.lastIndexOf('_'));

               // si estan definidos ambos dientes del puente devuelvo el tratamiento
			   if(pdiente>0 && udiente>0 && diente.id==pdiente){ 
			   	  esProtesisf = true;
			   	  protesisfcompleto = true;
			   	  salida=[esProtesisf,color,pdiente,udiente, protesisfcompleto];
			   }
			   // con que uno este definido ya es puente
			   if(pdiente>0 && udiente>0 && diente.id==pdiente){ 
			   	  esProtesisf = true;
			   	  salida=[esProtesisf,color,pdiente,udiente, protesisfcompleto];
			   }
			  
			} 
		};
        
        }
        catch(err) {
		    
		}
      	return salida;

	}

	// Crea un nuevo protesis fija o cierra alguno abierto
	function actualizarProtesisf(diente){
		
		var actualizarProtesis = false;
		var error = false;
	
		var tratamiento_abierto_protesis = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
		    var eldiente = t.diente.id.toString(); 
           
            // SI no tienes guiones y es protesis fija, esta incompleta la protesis fija
		    if (eldiente.indexOf('_') <= -1 && t.tratamiento.id == "01.09") { 
		    	error = true;
		    	actualizarProtesis = true; // esto es para que no agregue un registro

		    	if((t.diente.id>=11 && t.diente.id<=28) && (diente.id>=11 && diente.id<=28)){
		    		t.diente.id += "_"+diente.id.toString();
		   	        error = false;
		    	}
		    	if((t.diente.id>=51 && t.diente.id<=65) && (diente.id>=51 && diente.id<=65)){
		    		t.diente.id += "_"+diente.id.toString();
		   	        error = false;
		    	}
		    	if((t.diente.id>=71 && t.diente.id<=85) && (diente.id>=71 && diente.id<=85)){
		    		t.diente.id += "_"+diente.id.toString();
		   	        error = false;
		    	}
		    	if((t.diente.id>=31 && t.diente.id<=48) && (diente.id>=31 && diente.id<=48)){
		    		t.diente.id += "_"+diente.id.toString();
		   	        error = false;
		    	}

		  	} 
		});	

		var salida=[actualizarProtesis,error];
		return salida;

   }

   function calcularDistanciaProtesisf(diente1, diente2){
		
		var d1 = 0;
		var d2 = 0;
		var agregado=0;
		var extrasize = 0;
		var diff=0;
		var diff1=0;
		var diff2=0;
		var longitud = 0;
		var largo = 22;
		var indice = 0;

		if(diente1>=diente2){
			d1 = diente2;
			d2 = diente1;
		}

		if(diente2>=diente1){
			d1 = diente1;
			d2 = diente2;
		}

        // Diferencia normal entre dientes en el mismo sector se calcula por defecto
		diff= d2-d1+1; 
	    // en la misma banda despues de 4 dientes hay que mejorar el marcado
		if (diff>4){
           agregado = (2 * diff) + 5;
		} else {
			agregado = (2 * diff) + 1;
		}
    	longitud = (largo * diff) + agregado + extrasize; 

    	
		// en este punto d1 es el menor valor y d2 el mayor
		if((d1>=11 && d1<=18) && (d2>=21 && d2<=28)){
            extrasize = 10;
            diff1= d1-11; 
            diff2=d2-21;
            diff= diff1+diff2+2;
            switch (diff)
			{
			    case 4: indice = 1;break; case 5: indice = 2;break; case 6: indice = 3;break; case 7: indice = 4;break; case 8: indice = 7;break;
			    case 9: indice = 7;break; case 10: indice = 7;break; case 11: indice = 8;break; case 12: indice = 10;break; case 13: indice = 10;break;
			    case 14: indice = 12;break; case 15: indice = 12;break; case 16: indice = 14;break; case 17: indice = 14;break; case 18: indice = 15;break;
			    case (diff > 19):
			        indice = 15;   
			    break;
			}
	    	agregado = (2 * diff) + indice;
	    	longitud = (largo * diff) + agregado + extrasize; 
		} 

        if((d1>=51 && d1<=55) && (d2>=61 && d2<=65)){
            extrasize = 10;
            diff1= d1-51; 
            diff2=d2-61;
            diff= diff1+diff2+2;
            switch (diff)
			{
			    case 2: indice = 0; break; case 3: indice = 0; break; case 4: indice = 1;break; case 5: indice = 2;break; case 6: indice = 3;break; case 7: indice = 4;break; case 8: indice = 7;break;
			    case 9: indice = 7;break; case 10: indice = 7;break;
			}
	    	agregado = (2 * diff) + indice;
	    	longitud = (largo * diff) + agregado + extrasize;  
        } 

        if((d1>=71 && d1<=75) && (d2>=81 && d2<=85)){
            extrasize = 10;
            diff1= d1-71; 
            diff2=d2-81;
            diff= diff1+diff2+2;
            switch (diff)
			{
			    case 2: indice = 0; break; case 3: indice = 0; break; case 4: indice = 1;break; case 5: indice = 2;break; case 6: indice = 3;break; case 7: indice = 4;break; case 8: indice = 7;break;
			    case 9: indice = 7;break; case 10: indice = 7;break;
			}
	    	agregado = (2 * diff) + indice;
	    	longitud = (largo * diff) + agregado + extrasize; 
        } 

        if((d1>=31 && d1<=38) && (d2>=41 && d2<=48)){
            extrasize = 10;
            diff1= d1-31; 
            diff2=d2-41;
            diff= diff1+diff2+2;
            switch (diff)
			{
			    case 4: indice = 1;break; case 5: indice = 2;break; case 6: indice = 3;break; case 7: indice = 4;break; case 8: indice = 7;break;
			    case 9: indice = 7;break; case 10: indice = 7;break; case 11: indice = 8;break; case 12: indice = 10;break; case 13: indice = 10;break;
			    case 14: indice = 12;break; case 15: indice = 12;break; case 16: indice = 14;break; case 17: indice = 14;break; case 18: indice = 15;break;
			    case (diff > 19):
			        indice = 15;   
			    break;
			}
	    	agregado = (2 * diff) + indice;
	    	longitud = (largo * diff) + agregado + extrasize; 
        } 
		
		return longitud;
	}
	/* FIN LOGICA Protesis fija */

	
	function tempAlert(msg,duration,msgtype)
	{
	 var el = document.createElement("div");
	 if(msgtype=="red"){
	    el.setAttribute("style","height:30px;font-weight: bold;position:absolute;top:90%;left:40%;color:white;background-color:#FF0000;");
	 } else {
	 	el.setAttribute("style","height:30px;font-weight: bold;position:absolute;top:90%;left:40%;color:white;background-color:#7DBF0D;");
	 }
	 el.innerHTML = msg;
	 setTimeout(function(){
	  el.parentNode.removeChild(el);
	 },duration);
	 document.body.appendChild(el);
	}
	/* *FIN AGREGADOS POR MI PARA DETECTAR TIPO DE TRATAMIENTO */


	//View Models
	function DienteModel(id, x, y){
		var self = this;

		self.id = id;	
		self.x = x;
		self.y = y;		
	};

	function ViewModel(){
		var self = this;

		self.tratamientosPosibles = ko.observableArray([]);
		self.tratamientoSeleccionado = ko.observable(null);
		self.tratamientosAplicados = ko.observableArray([]);

		self.quitarTratamiento = function(tratamiento){
			self.tratamientosAplicados.remove(tratamiento);
			$('#jsonatenciones').val(JSON.stringify(self.tratamientosAplicados()));
			renderSvg();
		}

		//Cargo los dientes
		var dientes = [];
		//Dientes izquierdos
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(18 - i, i * 25, 10));	
		}
		for(var i = 3; i < 8; i++){
			dientes.push(new DienteModel(58 - i, i * 25, 1 * 50));	
		}
		for(var i = 3; i < 8; i++){
			dientes.push(new DienteModel(88 - i, i * 25, 2 * 50));	
		}
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(48 - i, i * 25, 3 * 50));	
		}
		//Dientes derechos
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(21 + i, i * 25 + 210, 10));	
		}
		for(var i = 0; i < 5; i++){
			dientes.push(new DienteModel(61 + i, i * 25 + 210, 1 * 50));	
		}
		for(var i = 0; i < 5; i++){
			dientes.push(new DienteModel(71 + i, i * 25 + 210, 2 * 50));	
		}
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(31 + i, i * 25 + 210, 3 * 50));	
		}

		self.dientes = ko.observableArray(dientes);
	};
    
    try{

	vm = new ViewModel();
	
	//Inicializo SVG
    $('#odontograma').svg({
        settings:{ width: '620px', height: '300px' }
    });

	ko.applyBindings(vm);

	//Cargo los tratamientos
	$.getJSON('../../../js/tratamientos.js', function(d){
		for (var i = d.length - 1; i >= 0; i--) {
			var tratamiento = d[i];
			vm.tratamientosPosibles.push(tratamiento);
		};		
	});
    
    var jsonatenciones = JSON.parse($('#jsonatenciones').val());
    //alert(JSON.stringify(jsonatenciones));
	
	// Recorro tratamientos ya aplicados para visualizarlos al momento de cargar el odontograma
    for (var key in jsonatenciones) {
     		vm.tratamientosAplicados.push({diente: jsonatenciones[key]["diente"], cara: jsonatenciones[key]["cara"], tratamiento: jsonatenciones[key]["tratamiento"]});
    }

   renderSvg();

    }
    catch(err) {
		    
	}

});