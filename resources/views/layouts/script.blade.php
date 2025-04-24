<!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>




    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>

    
    <!------- Configuraciones generales de datatables ---->
    <script src="{{asset('assets/js/configDatatables.js')}}"></script>
    <!------- Funciones generales de datatables ---->
    <script src="{{asset('assets/js/funcionesGDatatables.js')}}"></script>
    <!--- utilidades generales ---->
    <script src="{{ asset('assets/js/utils.js') }}"></script>

    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<!-- <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script> -->

<!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

<!-- Sweet Alert -->
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert2.all.js') }}"></script>
<!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

<!-- Kaiadmin DEMO methods, dont include it in your project! -->
<!-- <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script> -->
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });

        $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#f3545d",
            fillColor: "rgba(243, 84, 93, .14)",
        });

        $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#ffa534",
            fillColor: "rgba(255, 165, 52, .14)",
        });
    </script>
<! ----------script para llenar el body de los modales ----->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejo de modales de crear y editar
            ['crear', 'editar'].forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.addEventListener('show.bs.modal', function(event) {
                        const modalBody = this.querySelector('.modal-body');
                        const button = event.relatedTarget; // Botón que abrió el modal
                        const formUrl = button.getAttribute('data-form-url'); // URL del formulario
                        const id = button.getAttribute('data-id'); // ID del registro (para editar)
                        modalBody.innerHTML = '<p>Cargando...</p>'; // Indicador de carga

                        if (formUrl) {
                            const url = id && modalId === 'editar' ? formUrl : formUrl;

                            fetch(url)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Error al cargar el formulario');
                                    }
                                    return response.text();
                                })
                                .then(html => {
                                    modalBody.innerHTML = html;
                                })
                                .catch(error => {
                                    console.error(error);
                                    modalBody.innerHTML =
                                        '<p class="text-danger">Error al cargar el formulario</p>';
                                });
                        } else {
                            console.error('URL del formulario no proporcionada');
                            modalBody.innerHTML = '<p>Error: URL no proporcionada</p>';
                        }
                    });

                    // Limpia el modal al cerrarse
                    modal.addEventListener('hidden.bs.modal', function() {
                        this.querySelector('.modal-body').innerHTML = '';
                    });
                }
            });

        });
    </script>
    <!-- Datatables -->
    <script>
        {{--  $(document).ready(function() {
          
            initDataTable('datatables');
        });  --}}
    </script>

    <!-- Validaciones y alertas  -->
    <script src="{{ asset('assets/js/sistema.js') }}"></script>
    {{--  <script src="{{asset('assets/js/crud-table.js')}}"></script>  --}}
