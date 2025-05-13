import './bootstrap';

const activaCarruselTotal = {
    init: function () {
        this.launch();
    },
    launch: function () {

        $(".owl-carousel").owlCarousel({
            items: 3,               // Número de elementos a mostrar
            loop: true,             // Si el carrusel debe hacer un loop infinito
            margin: 20,             // Espacio entre los elementos
            autoplay: false,         // Reproducir automáticamente
            autoplayTimeout: 3000,  // Tiempo entre los deslizamientos (en milisegundos)
            dots: true,            // Activar los dots
            nav: false,             // Desactivar flechas de navegación
            responsive: {
                0: {
                    items: 1         // En pantallas pequeñas, solo 1 elemento
                },
                800: {
                    items: 2         // En pantallas medianas, 2 elementos
                },
                1000: {
                    items: 3         // En pantallas grandes, 3 elementos
                }
            }
        });
    }
};

const activaCarrusel = {
    init: function () {
        this.launch();
    },
    launch: function () {

        if ($(window).width() < 1200) {
            $(".owl-carousel").owlCarousel({
                items: 3,               // Número de elementos a mostrar
                loop: true,             // Si el carrusel debe hacer un loop infinito
                margin: 20,             // Espacio entre los elementos
                autoplay: false,         // Reproducir automáticamente
                autoplayTimeout: 3000,  // Tiempo entre los deslizamientos (en milisegundos)
                dots: true,            // Activar los dots
                nav: false,             // Desactivar flechas de navegación
                responsive: {
                    0: {
                        items: 1         // En pantallas pequeñas, solo 1 elemento
                    },
                    600: {
                        items: 2         // En pantallas medianas, 2 elementos
                    },
                    1000: {
                        items: 3         // En pantallas grandes, 3 elementos
                    }
                }
            });
        }

    }
};

const iniciaCarruselMax = {
    init: function () {
        this.launch();
    },
    launch: function () {

        console.log("Carrusel iniciado");

        activaCarrusel.init();

        $(window).resize(function () {
            // Eliminar el carrusel si la ventana es mayor o igual a 1200px
            if ($(window).width() >= 1200) {
                if ($(".owl-carousel").hasClass("owl-loaded")) {
                    $(".owl-carousel").trigger('destroy.owl.carousel').removeClass("owl-loaded");
                }
            } else {
                activaCarrusel.init();
            }
        });

    }
};

// Activa un oyente para ver si un formulario ha sido modificado
const checkForm = {
    init: function () {
        this.launch();
    },
    launch: function () {

        const formulario = document.getElementById("myForm");
        const boton = document.getElementById("submitButton");
        if (boton != null) {
            boton.classList.add("disabled");
        }

        if (formulario != null) {
            // Guarda los valores iniciales del formulario
            const valoresIniciales = new FormData(formulario);

            const activo1 = valoresIniciales.getAll("activo")[1];
            const block1 = valoresIniciales.getAll("bloqueado")[1];

            formulario.addEventListener("input", function () {
                const valoresActuales = new FormData(formulario);
                let modificado = false;

                const activo2 = valoresActuales.getAll("activo")[1];
                const block2 = valoresActuales.getAll("bloqueado")[1];

                // Compara los valores actuales con los iniciales
                for (let [clave, valor] of valoresActuales.entries()) {
                    // Verifica el checkbox ya que FormData no lo hace bien
                    if (activo1 != activo2 || block1 != block2) {
                        modificado = true;
                        break;
                    }
                    // Verifica si la imagen tiene un nombre, si lo tiene, es que se ha cargado una imagen
                    if (valor instanceof File) {
                        if (valoresActuales.get("image").name != '') {
                            modificado = true;
                            break;
                        }

                    } else if (valor != valoresIniciales.get(clave)) {
                        modificado = true;
                        break;
                    }
                }

                // Muestra u oculta el botón según si hubo cambios
                if (modificado) {
                    boton.classList.remove("disabled");
                } else {
                    boton.classList.add("disabled");
                }
            });

        }

    }
};

// Abre (desoculta) el modal según su id recibido
window.confirmDelete = function (mensaje) {

    return confirm(mensaje);

};

// Abre (desoculta) el modal según su id recibido
window.openModal = function (modal) {

    // Obtener los elementos
    const modalWindow = document.getElementById(modal);

    if (modalWindow != null) {
        // Botón cerrar del modal
        const closeModal = modalWindow.querySelector(".close");

        // Abrir el modal con efecto de fade-in
        modalWindow.style.display = "flex"; // Mostrar el modal
        setTimeout(() => modalWindow.classList.add("show"), 10); // Iniciar la animación

        // Cerrar el modal con efecto de fade-out
        closeModal.addEventListener("click", () => {
            modalWindow.classList.remove("show"); // Iniciar el fade-out
            setTimeout(() => (modalWindow.style.display = "none"),
                500); // Esperar la animación antes de ocultarlo
        });

        // Cerrar el modal al hacer clic fuera del contenido
        window.addEventListener("click", (e) => {
            if (e.target === modalWindow) {
                modalWindow.classList.remove("show"); // Iniciar el fade-out
                setTimeout(() => (modalWindow.style.display = "none"),
                    500); // Esperar la animación antes de ocultarlo
            }
        });

    }

};

// Inserta una página modal recibida por la ruta de un controlador
window.insertModalPage = function (ruta, hasImage, checkF) {

    // Línea HTML en la que se agregará la página modal
    // HA DE ESTAR DEFINIDA EN LA PÁGINA
    const modalContent = document.getElementById('modalPageContent');
    const spinner = document.getElementById('spinner');

    if (modalContent != null) {
        spinner.style.display = 'block';
        // Realiza una solicitud AJAX para cargar el contenido del modal
        fetch(ruta)
            .then(response => response.text())
            .then(html => {
                modalContent.innerHTML = html; // Inserta el contenido en el modal
                // Una vez insertada la página modal, la visualiza
                spinner.style.display = 'none';

                // Si el formulario tiene imágenes de carga, activo el escuchador
                if (hasImage) {
                    imageViewer.init();
                }

                // Checkeo de formulario
                if (checkF) {
                    checkForm.init();
                }

                // openModal(modalName);
                openModal('modal-page');
            })
            .catch(error => {
                alert('Error al cargar el contenido');

            });
    }
}

// Establece los valores en un formulario y lo abre como modal
window.openModalModify_BORRAR = function (nombre, bloqueado, rol, rutaCreate, rutaDelete, modal) {
    const modalUser = document.getElementById(modal);

    modalUser.querySelector('#nombre').innerText = "Modificar usuario " + nombre;
    modalUser.querySelector('#bloqueado').value = bloqueado;
    if (rol != null) {
        modalUser.querySelector('#rol').value = rol;
    }
    // Establecer la acción del formulario
    modalUser.querySelector('#editForm').setAttribute('action', rutaCreate);
    modalUser.querySelector('#delete').setAttribute('action', rutaDelete);

    openModal(modal);
}

// Abre el modal de añadir actividad y le asigna un id al input experiencia_id
window.addActivity = function (modal, experiencia_id) {
    const modalUser = document.getElementById(modal);

    if (modalUser != null) {
        modalUser.querySelector('#experiencia_id').value = experiencia_id;

        openModal(modal);
    }
}

// Activa la opción de cerrar un formulario abierto tras un error de contenido
if (document.querySelector('.modal.show')) {
    const modalOpened = document.getElementsByClassName("modal show")[0];

    if (modalOpened != null) {
        const closeModal = modalOpened.querySelector(".close");
        closeModal.addEventListener("click", () => {
            clearValidationErrors();
            modalOpened.classList.remove("show"); // Iniciar el fade-out
            setTimeout(() => (modalOpened.style.display = "none"),
                500); // Esperar la animación antes de ocultarlo
        });
    }
}

// Elimina todos los mensajes de error del formulario
window.clearValidationErrors = function () {
    // Eliminar errores del DOM
    const errorMessages = document.querySelectorAll('.error-message');
    if (errorMessages != null) {
        errorMessages.forEach(error => error.remove());
    }
}

// En los formularios con un slider selector, cambia el valor del output por
// el valor seleccionado en el selector
// Calcula el precio total y lo establece en total-price
window.updateSliderValue = function (value, output, priceAdult, priceChild) {
    document.getElementById(output).textContent = value;
    if (priceAdult != null) {
        const adult = parseInt(document.getElementById('value-adults').value);
        const child = parseInt(document.getElementById('value-child').value);
        document.getElementById('total-price').textContent = (((priceAdult * adult) + (priceChild * child))).toLocaleString('de-DE') + "€";
        document.getElementById('total-booking').textContent = ((adult + child) * 395).toLocaleString('de-DE') + "€";
    }
}


// Se ejecuta dentro de la página correspondiente
// Se ocupa de añadir una fecha a un listado y prepara el array
// para el controlador
const multipleDates = {
    init: function () {
        this.launch();
    },
    launch: function () {

        const idiomaPagina = document.documentElement.lang;

        var textoBoton = "";
        if (idiomaPagina == 'es') {
            textoBoton = "Añade nueva fecha";
        } else {
            textoBoton = "Add new date";
        }
        const fechaInput = document.getElementById('fechaInput');

        const listaFechas = document.getElementById('listaFechas');
        const fechasHidden = document.getElementById('fechasHidden');
        let fechas = JSON.parse(fechasHidden.value);
        if (fechaInput != null) {
            fechaInput.value = textoBoton;
            $("#fechaInput").datepicker({
                showButtonPanel: true,  // Opcional, muestra el panel con "Hoy" y "Cerrar"
                dateFormat: "yy-mm-dd",  // Establece el formato de la fecha
                onSelect: function (dateText, inst) {
                    if (dateText) {
                        // Agregar la fecha al array y renderizar la lista
                        fechas.push(dateText);
                        renderListaFechas();
                        fechaInput.value = textoBoton;

                    }
                }
            });
        }


        // Actualiza la lista de fechas
        function renderListaFechas() {
            // Vaciar la lista actual
            listaFechas.innerHTML = '';

            // Crear nuevos elementos de la lista
            fechas.forEach((fecha, index) => {
                const unaFecha = document.createElement('p');
                unaFecha.classList.add("one_date");
                unaFecha.textContent = fecha;

                // Botón para eliminar la fecha
                const eliminarBtn = document.createElement('button');
                eliminarBtn.textContent = 'X';
                eliminarBtn.type = 'button';
                eliminarBtn.addEventListener('click', () => {
                    // Eliminar la fecha del array y renderizar de nuevo
                    fechas.splice(index, 1);
                    renderListaFechas();
                });

                unaFecha.prepend(eliminarBtn);
                listaFechas.appendChild(unaFecha);
            });

            // Actualizar el campo oculto con el valor que se enviará al controlador
            fechasHidden.value = JSON.stringify(fechas);
        }

        // Pone las fechas que ya tiene la experiencia al cargar la página
        if (listaFechas != null) {
            renderListaFechas();
        }

    }
};

// Se carga en la página correspondiente
// Se encarga de mostrar en un div la imagen seleccionada
const imageViewer = {
    init: function () {
        this.launch();
    },
    launch: function () {

        console.log('imagen preview activado');

        const image = document.getElementById('image');

        if (image != null) {

            image.addEventListener('change', function (event) {
                const file = event.target.files[0]; // Obtener el archivo seleccionado
                const preview = document.getElementById('image-preview'); // Elemento de previsualización

                if (file) {
                    const reader = new FileReader();

                    // Cuando se carga la imagen, actualizar el src del <img>
                    reader.onload = function (e) {
                        preview.src = e.target.result;

                    };

                    reader.readAsDataURL(file); // Leer el archivo como una URL de datos
                } else {
                    preview.src = '#';
                }
            });
        }

    }
};



// Comprueba si el nombre de la experiencia introducido en el formulario ya existe en la BBDD
const checkName = {
    init: function () {
        this.launch();
    },
    launch: function () {

        let timeout;

        window.checkNombre = function (nombreOriginal) {

            clearTimeout(timeout);

            // Establecer un nuevo timeout de 1500 ms
            timeout = setTimeout(function () {
                // Llamada AJAX para comprobar si el texto existe en la base de datos
                let nombre = $('#nombreExp').val();

                console.log('Comprobando: ' + nombre);
                console.log('Original: ' + nombreOriginal);

                if (nombre.length > 0 && nombre != nombreOriginal) {
                    $.ajax({
                        url: '/check-name/' + nombre,
                        type: 'GET',
                        success: function (data) {
                            if (data.exists) {
                                $('#error-nombre').show();  // Muestra el error si el nombre ya existe
                            } else {
                                $('#error-nombre').hide();  // Oculta el error si el nombre no existe
                            }
                        }
                    });
                } else {
                    $('#error-nombre').hide();  // Oculta el error si el campo está vacío
                }

            }, 1500);

        }
    }
};

// Editor de texto avanzado
// Usar el id "editor-advanced" en el input del textarea para convertirlo en editor
const textEditor = {
    init: function () {
        this.launch();
    },
    launch: function () {

        CKEDITOR.replace('editor-advanced');
    }
};


document.addEventListener('scroll', function () {
    const elementos = document.querySelectorAll('.card-experience');
    const triggerPoint = window.innerHeight / 1.2; // Punto de activación

    if (elementos != null) {
        elementos.forEach((el) => {
            const elementTop = el.getBoundingClientRect().top;
            if (elementTop < triggerPoint) {
                el.classList.add('visible'); // Añade la clase cuando es visible
            }
        });
    }
});



// Se ejecuta al cargar la página (JQUERY)
$(function () {
    // Recoge el valor de la clase content de la página
    const content = $('.content');

    // Si la página es la del menú proveedor ejecuta las funciones que va a utilizar
    // -- Esto evita que esas funciones se carguen en todas las páginas --
    if (content.hasClass('form-experience')) {
        imageViewer.init();
        multipleDates.init();
        textEditor.init();
        checkName.init();
    }

    // activa el editor de texto avanzado en la página de crear experiencia
    if (content.hasClass('form-activity')) {
        textEditor.init();
        imageViewer.init();
    }

    // activa el oyente para activar el boton del formulario
    if (content.hasClass('user-profile')) {
        checkForm.init();
        imageViewer.init();
    }

    // Si la página contiene la clase "home" ejecuta el carrusel
    if (content.hasClass('home')
        || content.hasClass('experiences')
        || content.hasClass('provider-login')
        || content.hasClass('user-profile')
        || content.hasClass('experience-detail')
    ) {
        activaCarruselTotal.init();
    }
});
