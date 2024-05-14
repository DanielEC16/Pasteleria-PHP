const productos = document.getElementById("products");

function getData(){
    fetch('productos.json')
        .then(res=>res.json)
        .then(datos=>{
            console.log(datos);
        })
}


getData()
