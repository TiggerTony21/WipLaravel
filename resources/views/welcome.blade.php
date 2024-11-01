<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Código QR</title>
    <link rel="stylesheet" href="stylesgeneracion.css">
    <link href="{{ asset('css/stylesgeneracion.css') }}" rel="stylesheet"
</head>
<body>
    <!-- Header con barra de navegación -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="{{ asset('image.png') }}" alt="Logo Universidad">}
            </div>
            <ul class="nav-links">
                <li><a href="#home">Inicio</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#contacto">Contacto</a></li>
                <li><a href="#nosotros">Nosotros</a></li>
            </ul>
        </nav>
    </header>

    <!-- Sección principal con formulario y botón de generación de QR -->
    <main>
        <section class="home-section">
            <h1>Registro de Asistencia por Grupo</h1>
            <p>Completa el formulario con la información del grupo antes de generar el código QR.</p>

            <!-- Contenedor para el formulario y el resumen -->
            <div class="form-qr-container">
                <!-- Formulario de información del grupo -->
                <form action="{{ url('guardar-grupo') }}" method="POST" id="groupForm"> 
                    @csrf
                    <div class="form-group">
                        <label for="nombreGrupo">Nombre del Grupo:</label>
                        <input type="text" id="nombreGrupo" name="nombreGrupo" required value="{{ old('nombreGrupo') }}">
                    </div>
                    <div class="form-group">
                        <label for="materia">Materia:</label>
                        <input type="text" id="materia" name="materia" required value="{{ old('materia') }}">
                    </div>
                    <div class="form-group">
                        <label for="fechaClase">Fecha de la Clase:</label>
                        <input type="date" id="fechaClase" name="fechaClase" required value="{{ old('fechaClase') }}">
                    </div>
                    <div class="form-group">
                        <label for="profesor">Profesor:</label>
                        <input type="text" id="profesor" name="profesor" required value="{{ old('profesor') }}">
                    </div>
                    <div class="form-group">
                        <label for="horarioClase">Horario de la Clase: </label>
                        <input type="time" id="horarioClase" name="horarioClase" required value="{{ old('horarioClase') }}">
                    </div>
                    <div class="form-group">
                        <label for="horarioClaseFinal">Horario de Clase Finalizada: </label>
                        <input type="time" id="horarioClaseFinal" name="horarioClaseFinal" required value="{{ old('horarioClaseFinal') }}">
                    </div>
                    <div class="form-group">
                        <label for="horarioRegistro">Horario de Registro Activo: </label>
                        <input type="time" id="horarioRegistro" name="horarioRegistro" required value="{{ old('horarioRegistro') }}">
                    </div>
                    <!-- Botón para generar código QR -->
                    <button type="submit" id="generateQRButton">Generar Código QR</button>
                </form>

                <!-- Resumen del código QR generado -->
                <div class="qr-summary">
                    <div id="qrContainer" class="qr-container" value="{{ old('qrContainer') }}"></div>
                    <p id="qrCodeText"></p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2024 Universidad - Todos los derechos reservados</p>
    </footer>

    <!-- Incluir la librería qrcode.js localmente o desde un CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <!-- Script para generar el código QR -->
    <script>
        // Función para generar un UUID (Identificador único)
        function generarUUID() {
            return 'xxxxxxxx-xxxx-4xxx-\nyxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        // Función para generar un código QR único basado en el formulario
        function generarCodigoQR(event) {
            event.preventDefault(); // Prevenir que el formulario se envíe

            // Limpiar cualquier QR anterior
            const qrContainer = document.getElementById('qrContainer');
            qrContainer.innerHTML = ''; // Limpiar el contenedor del QR

            // Obtener los datos del formulario
            const nombreGrupo = document.getElementById('nombreGrupo').value;
            const materia = document.getElementById('materia').value;
            const fechaClase = document.getElementById('fechaClase').value;
            const profesor = document.getElementById('profesor').value;
            const horarioClase = document.getElementById('horarioClase').value;
            const horarioClaseFinal = document.getElementById('horarioClaseFinal').value;
            const horarioRegistro = document.getElementById('horarioRegistro').value;

            // Validar que todos los campos estén llenos
            if (!nombreGrupo || !materia || !fechaClase || !profesor || !horarioClase || !horarioClaseFinal || !horarioRegistro) {
                alert('Por favor, completa todos los campos del formulario.');
                return;
            }

            // Generar UUID
            const uuid = generarUUID();

            // Crear una cadena de texto que combine los datos del grupo, el horario y el estado de asistencia
            const qrData = `Grupo: ${nombreGrupo}\nMateria: ${materia}\nFecha: ${fechaClase}\nProfesor: ${profesor}\nHorario Clase: ${horarioClase}\nClase Finalizada: ${horarioClaseFinal}\nHorario Registro: ${horarioRegistro}\nID: ${uuid}`;

            // Mostrar los datos generados del QR
            document.getElementById('qrCodeText').innerText = `Datos del QR:\n${qrData}`;

            // Generar el código QR con la librería qrcode.js
            new QRCode(qrContainer, {
                text: qrData,
                width: 256,  // Ancho del código QR
                height: 256  // Alto del código QR
            });
        }

        // Añadir el evento al formulario para generar el código QR al enviarlo
        document.getElementById('groupForm').addEventListener('submit', generarCodigoQR);
    </script>
</body>
</html>
