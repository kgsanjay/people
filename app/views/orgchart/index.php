<?php 
$title = "Organizational Chart";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Company Hierarchy</h3>
    </div>
    <div class="card-body">
        <div id="chart_div" style="width: 100%; height: 600px;"></div>
    </div>
</div>

<script type="text/javascript">
  google.charts.load('current', {packages:['orgchart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Name');
    data.addColumn('string', 'Manager');
    data.addColumn('string', 'ToolTip');

    // For each orgchart box, provide the node's ID, the manager's ID, and an optional tooltip.
    // The 'v' property is the unique ID, 'f' is the formatted content.
    var chartData = <?php echo $chartDataJson; ?>;
    
    // Convert the PHP array to the format Google Charts expects
    var rows = chartData.map(function(row) {
        return [
            { v: row[0].v, f: row[0].f },
            row[1],
            row[2]
        ];
    });

    data.addRows(rows);

    // Create the chart.
    var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
    // Draw the chart, setting the allowHtml option to true for the custom formatting.
    chart.draw(data, {'allowHtml':true, 'size': 'large'});
  }
</script>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
