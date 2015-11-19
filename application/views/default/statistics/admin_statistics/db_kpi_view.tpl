{foreach $kpis as $key => $kpi}
    <div class="kpi"  >
        <div id="chart_div_{$key}">
            <script type="text/javascript">
                google.setOnLoadCallback(draw_kpi_chart('chart_div_{$key}', '{$kpi.name}', {$kpi.current_kpi}, {$kpi.total_kpi}));
            </script>

        </div>
    </div>
{/foreach}
