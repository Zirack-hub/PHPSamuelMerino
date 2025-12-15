let productos = [];
let cantidadP = 0;

const tablaProductos = document.getElementById("tablaProductos");
const formulario = document.getElementById("formulario");
const mostrarInformacionProducto = document.getElementById("mostrarInformacionProducto");
const aparecerFormulario = document.getElementById("aparecerFormulario");
const cantidadProductos = document.getElementById("cantidadProductos");

function generarInformacionProductos() {
    for (let producto of productos) {
        const img = document.getElementById("img-" + producto.id);
        const informacion = document.getElementById("informacion-" + producto.id);

        if (img && informacion) {
            img.addEventListener("click", () => {
                if (informacion.style.display === "block") {
                    informacion.style.display = "none";
                } else {
                    mostrarInformacion(informacion, producto.nombre, producto.id, producto.precio, producto.descripcion);
                }
            });
            img.addEventListener("contextmenu", (e) => {
                eliminarProducto(e, producto.nombre, producto.id);
            });
        }
    }
}

function eliminarProducto(e, nombre, id) {
    e.preventDefault();
    if (confirm(`¿Eliminar producto "${nombre}"?`)) {
        productos = productos.filter(p => p.id != id);
        let cantidad = productos.length;
        cantidadProductos.innerHTML = `Cantidad = ${cantidad}`;
        mostrarTabla();
    }
}

function mostrarInformacion(informacion, nombre, id, precio, descripcion) {
    informacion.style.display = "block";
    informacion.innerHTML = `
        <p>
            <b>ID</b> --> ${id}</br>
            <b>Nombre</b> --> ${nombre}</br>
            <b>Precio</b> --> ${precio}€</br>
        </p>
        <p><b>Descripción:</b> ${descripcion}</p>
    `;
}

aparecerFormulario.addEventListener("click", () => {
    if (formulario.style.display === "block") {
        formulario.style.display = "none";
    } else {
        mostrarFormulario();
    }
});

function mostrarFormulario() {
    formulario.style.display = "block";
    formulario.innerHTML = `
        <form id="productos">
            <label for="id">ID:</label>
            <input class="input" id="id" type="text">
            <label for="nombre">Nombre:</label>
            <input class="input" id="nombre" type="text">
            <label for="descripcion">Descripcion:</label>
            <input class="input" id="descripcion" type="text">
            <label for="precio">Precio:</label>
            <input class="input" id="precio" type="number">
            <label for="imagen">Imagen:</label>
            <input class="input" id="imagen" type="file">
            <button id="agregar" type="button">Agregar Producto</button>
        </form>
    `;

    const agregar = document.getElementById("agregar");

    agregar.addEventListener("click", () => {
        const id_elemento = document.getElementById("id");
        const nombre_elemento = document.getElementById("nombre");
        const descripcion_elemento = document.getElementById("descripcion");
        const precio_elemento = document.getElementById("precio");
        const imagen_elemento = document.getElementById("imagen");

        let id = id_elemento.value;
        id = String(id);
        const nombre = nombre_elemento.value;
        const descripcion = descripcion_elemento.value;
        const precio = precio_elemento.value;
        const imagen = imagen_elemento.files[0];

        const error = comprobarDatos(id, id_elemento, nombre, nombre_elemento, descripcion,
                                     descripcion_elemento, precio, precio_elemento, imagen,
                                     imagen_elemento);

        if (error) return;

        const urlImagen = URL.createObjectURL(imagen);

        if (!id) id = String(cantidadP++);   

        const producto = { id: String(id), nombre, descripcion, precio, imagen: urlImagen };
        productos.push(producto);

        mostrarTabla();
        formulario.style.display = "none";
    });
}

function comprobarDatos(id, id_elemento, nombre, nombre_elemento, descripcion, descripcion_elemento,
                        precio, precio_elemento, imagen, imagen_elemento) {

    let error = false;
    const regexID = /^.{1,8}$/;            // Máx 8 caracteres
    const regexNombre = /^[\w\s]{1,10}$/;  // Máx 10 caracteres (letras, números, guion_bajo, espacios)

    // --- Comprobar ID DUPLICADAS ---
    for (let producto of productos) {
        if (id === producto.id) {
            error = true;
            mostrarError(id_elemento, "Id duplicada, ingrese una id diferente");
        }
    }
    
    // --- Validar ID ---
    if (id && !regexID.test(id)) {
        error = true;
        mostrarError(id_elemento, "La id no puede tener más de 8 caracteres");
    }

    // --- Validar Nombre ---
    if (!nombre) {
        error = true;
        mostrarError(nombre_elemento, "Nombre es un campo obligatorio");
    } else if (!regexNombre.test(nombre)) {
        error = true;
        mostrarError(nombre_elemento, "El nombre no puede superar los 10 caracteres");
    }

    // --- Validar Descripción ---
    if (!descripcion) {
        error = true;
        mostrarError(descripcion_elemento, "Descripción es un campo obligatorio");
    }

    // --- Validar Precio ---
    if (!precio) {
        error = true;
        mostrarError(precio_elemento, "Precio es un campo obligatorio");
    } else if (precio <= 0) {
        error = true;
        mostrarError(precio_elemento, "Precio debe ser mayor que 0");
    }

    // --- Validar Imagen ---
    if (!imagen) {
        error = true;
        mostrarError(imagen_elemento, "Imagen es un campo obligatorio");
    }

    return error;
}

function mostrarError(elemento, error) {
    elemento.classList.add("input-error");
    elemento.value = "";
    elemento.placeholder = error;
}

function mostrarTabla() {
    tablaProductos.innerHTML = "";
    let tabla = `<div class="grid-productos">`;

    for (let producto of productos) {
        tabla += `
            <div class="producto">
                <div class="item">
                    <img src="${producto.imagen}" id="img-${producto.id}" alt="${producto.nombre}">
                </div>
                <div id="informacion-${producto.id}" class="informacion_imagen"></div>
            </div>
        `;
    }

    tabla += `</div>`;
    tablaProductos.innerHTML = tabla;
    let cantidad = productos.length;
    cantidadProductos.innerHTML = `Cantidad = ${cantidad}`;
    generarInformacionProductos();
}
