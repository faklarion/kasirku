</div>
</main>
</body>
<h6 class="text-right p-2"> Jivi MG <i class="fa fa-copyright"></i> <?= date('Y')?> &nbsp;&nbsp;&nbsp;</h6>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script>
function printIni(){
		window.print();
}


$(document).ready(function(){
  $('.app-sidebar__toggle').on('click', function(){
    $('.app').toggleClass('sidenav-toggled');
  });
});

$(document).ready(function() {
    $('#tabelKu').DataTable({
        "responsive": true, // Mengaktifkan fitur responsif
        "paging": true,     // Menambahkan pagination
        "searching": true,  // Menambahkan kotak pencarian
        "ordering": true,   // Menambahkan fitur pengurutan
    });
});


</script>

