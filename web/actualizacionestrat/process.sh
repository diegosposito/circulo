cd /home/projects/circulo/web/actualizacionestrat

cat *.sql > process.upd

mysql -uroot -proot911 circulo < process.upd

rm *.sql

rm *.upd
