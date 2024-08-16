const mysql = require('mysql');
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'DeportesBLIT',
  password: 'BLIT1110',
  database: 'ecommerse'
});

connection.connect((err) => {
  if (err) throw err;
  console.log('Conectado a la base de datos.');
});