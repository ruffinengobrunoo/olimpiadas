// conexion a bd con nodejs

const express = require('express')
    const mysql = require('mysql')
    const app = express();
    const port = 4000
    app.use(express.static('admin'));
    app.use(express.json());

    app.use(express.urlencoded({extended:false}))
   
    const conexion = mysql.createConnection({

        host: 'localhost',
        database: 'eccommercebd',
        // database: 'prueba',
        user: 'root',
        password: '',

    })

    conexion.connect(function(error){
        if(error){
            throw error;
        }else{
            console.log('conexion exitosa')
            
        }
    });

    app.get("/", (req, res) => {
        res.sendFile(__dirname + '/admin/admin.html');
    })

    app.listen(port, () =>{
        console.log("corriendo en puerto")
    })
    // app.get("/", (req, res)=>{
       
    //         res.render('admin/admin')
            
    // })

    

// subir registros
    
        

    app.post("/formulario", (req, res)=>{

        const datos = req.body
        let nombre = datos.nombreDelProducto;
        let precio = datos.existenciaAñadir;
        let stock = datos.valorAñadir;
        let desc = datos.descripAñadir;
        let img = datos.imagenAñadir;
        console.log(datos);

        let registrar = "INSERT INTO `articulos`(`nombre_art`, `stock`, `precio`, `descripcion`, `url`) VALUES ('"+nombre+"','"+stock+"','"+precio+"','"+desc+"','"+img+"')";

        conexion.query(registrar,(error) =>{
            if(error){
                throw error;
            }else{
                console.log("registro completo")
            }
        } );

    // editar

    app.put("/editar", (req, res) => {
    const id = req.params.id;
    const { nombre, precio, stock, descripcion, url } = req.body;

    let actualizar = "UPDATE `articulos` SET `nombre_art` = ?, `stock` = ?, `precio` = ?, `descripcion` = ?, `url` = ?";
    
    conexion.query(actualizar, [nombre, stock, precio, descripcion, url], (error, results) => {
        if (error) {
            console.error(error);
            return res.status(500).json({ message: 'Error al editar el producto' });
        } else {
            console.log('Producto actualizado con éxito');
            return res.status(200).json({ message: 'Producto actualizado con éxito' });
        }
    });
});


// Borrar un registro
app.delete("/borrar", (req, res) => {
    const id = req.params.id;

    let eliminar = "DELETE FROM `articulos` WHERE `nombre_art` = ?";
    
    conexion.query(eliminar, nombre, (error, results) => {
        if (error) {
            console.error(error);
            return res.status(500).json({ message: 'Error al borrar el producto' });
        } else {
            console.log('Producto borrado con éxito');
            return res.status(200).json({ message: 'Producto borrado con éxito' });
        }
    });
});

    })

    
    


