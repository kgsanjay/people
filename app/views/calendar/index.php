<?php 
$title = "Company Calendar";
ob_start(); 
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Company Events & Leave</h3>
    </div>
    <div class="card-body">
        <div id='calendar'></div>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
      },
      events: <?php echo $eventsJson; ?>,
      // Bootstrap 5 theme integration
      themeSystem: 'bootstrap5'
    });
    calendar.render();
  });
</script>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
