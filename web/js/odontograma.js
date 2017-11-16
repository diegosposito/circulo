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
      	if (esExtraccion(diente)[0]){
    		
    		// Cambio color del poligono, en este caso pinta las extracciones
    		defaultPolygon = {fill: 'white', stroke: esExtraccion(diente)[1], strokeWidth: 0.5};

    		var caraSS = svg.polygon(dienteGroup,
				[[0,0],[5,5],[10,10],[20,20]],  
			    defaultPolygon);
		    caraSS = $(caraSS).data('cara', 'SS');
		
			var caraII =  svg.polygon(dienteGroup,
				[[20,0],[15,5],[10,10],[0,20]],  
			    defaultPolygon);			
			caraII = $(caraII).data('cara', 'II');
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

        // SOlo pinto si no es extraccion
		if (!esExtraccion(diente)[0]){
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
					alert('Debe seleccionar un tratamiento previamente.');	
					return false;
				}

				//Validaciones
				//Validamos el tratamiento
				var t = vm.tratamientoSeleccionado();
				t.color = $("#selectedcolor").val();

				var tratamiento = jQuery.extend({}, t);

				if(cara == 'X' && !tratamiento.aplicaDiente){
					alert('El tratamiento seleccionado no se puede aplicar a toda la pieza.');
					return false;
				}
				if(cara != 'X' && !tratamiento.aplicaCara){
					alert('El tratamiento seleccionado no se puede aplicar a una cara.');
					return false;
				}
				//TODO: Validaciones de si la cara tiene tratamiento o no, etc...

				vm.tratamientosAplicados.push({diente: diente, cara: cara, tratamiento: tratamiento});
				$('#jsonatenciones').val(JSON.stringify(vm.tratamientosAplicados()));
				//alert (JSON.stringify(vm.tratamientosAplicados()));
				//vm.tratamientoSeleccionado(null);
				
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

	function esExtraccion(diente){
		
		var esExt = false;
		var color = 'blue';

		var trat_apli_al_diente = ko.utils.arrayFilter(vm.tratamientosAplicados(), function(t){
			return t.diente.id == diente.id;
		});	

     
		for (var i = 0; i <= trat_apli_al_diente.length - 1; i++) {
			var t = trat_apli_al_diente[i];
            
          	if (t.tratamiento.id == "10.18"){
			  esExt = true;
			  color = t.tratamiento.color;
          	}  
		};

        var salida=[esExt,color];
		return salida;
	}

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
			renderSvg();
		}

		//Cargo los dientes
		var dientes = [];
		//Dientes izquierdos
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(18 - i, i * 25, 0));	
		}
		for(var i = 3; i < 8; i++){
			dientes.push(new DienteModel(58 - i, i * 25, 1 * 40));	
		}
		for(var i = 3; i < 8; i++){
			dientes.push(new DienteModel(88 - i, i * 25, 2 * 40));	
		}
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(48 - i, i * 25, 3 * 40));	
		}
		//Dientes derechos
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(21 + i, i * 25 + 210, 0));	
		}
		for(var i = 0; i < 5; i++){
			dientes.push(new DienteModel(61 + i, i * 25 + 210, 1 * 40));	
		}
		for(var i = 0; i < 5; i++){
			dientes.push(new DienteModel(71 + i, i * 25 + 210, 2 * 40));	
		}
		for(var i = 0; i < 8; i++){
			dientes.push(new DienteModel(31 + i, i * 25 + 210, 3 * 40));	
		}

		self.dientes = ko.observableArray(dientes);
	};

	vm = new ViewModel();
	
	//Inicializo SVG
    $('#odontograma').svg({
        settings:{ width: '620px', height: '250px' }
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
	
	// Recorro tratamientos ya aplicados para visualizarlos al momento de cargar el odontograma
    for (var key in jsonatenciones) {
     		vm.tratamientosAplicados.push({diente: jsonatenciones[key]["diente"], cara: jsonatenciones[key]["cara"], tratamiento: jsonatenciones[key]["tratamiento"]});
    }

    //Cargo los tratamientos
	/*$.getJSON('../../../js/taplicados.js', function(d){
		for (var i = d.length - 1; i >= 0; i--) {
			var fila = d[i];
			vm.tratamientosAplicados.push({diente: fila["diente"], cara: fila["cara"], tratamiento: fila["tratamiento"]});
		};		
	});
	//alert(JSON.stringify(jsonatenciones[key], null, 2));
     		//alert(jsonatenciones[key]["diente"]);
     		*/

	

	renderSvg();
});