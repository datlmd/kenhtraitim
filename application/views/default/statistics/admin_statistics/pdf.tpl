<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        
        <!-- CSS -->
        <!-- GLOBAL -->
        <link href="{static_base()}css/pdf-style.css" rel="stylesheet" type="text/css" />  
<!--        <script type="text/javascript" src="{static_base()}js/jquery-1.6.4.js"></script>
        <script type="text/javascript" src="{static_base()}js/admin/function.js"></script>

        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

        <script type="text/javascript">
            {literal}
            google.load("visualization", "1", {packages:["imagelinechart"]});
            {/literal}
        </script>-->

    </head>

    <body>

        <span id="MainWeb">

            <span id="MainContent">

                <span class="boxContent">



                    <span class="heading">
                        <h1>Campaign Informations</h1> 
                    </span>

                    <span class="content"  id="cp_wrapper" style="width: 98%;"> 

                        <form>   
                            {include file="./cp_list_view.tpl"}
                        </form>

                    </span>


                    <span class="heading">
                        <h1>GA Reports</h1> 
                    </span>

                    <span class="content"  id="cp_wrapper" style="width: 98%;"> 

                        <span class="kpis">
                            <form  >
                                <table class="filter">

                                    <tr>  
                                        <td>
                                            <h3>Current KPIs</h3>
                                        </td>

                                    </tr>

                                </table>
                            </form>
                            {foreach $ga_kpis as $kpi}
                                <span class="kpi"  >
                                    <span>                                    
                                        <img src="{$kpi}" />

                                    </span>
                                </span>
                            {/foreach}
                        </span>

                        <span class="data_div" style="margin-bottom: 15px;">
                            <form>
                                <table class="filter">
                                    <tbody>
                                        <tr>  
                                            <td>
                                                <h3>Overview Comparison</h3>
                                            </td>                        
                                        </tr>
                                    </tbody>
                                </table>
                            </form>

                            <span id="ga_compare">
                                <!--                                <script type="text/javascript">
                                                                    google.setOnLoadCallback(draw_pdf_compare_chart({$campaign_id}, "ga_compare", "/statistics/admin_statistics/ajax_get_ga_compare/"));
                                                                </script>-->
                                <img style="margin-left: 15px;" width="1450"  height="300" src="{base_url()}/statistics/admin_statistics/draw_compare_chart_type/ga/{$campaign_id}" />
                            </span>

                        </span>

                        <span {if $ga_page_break}class="page_break"{/if}>

                            <form>
                                <table class="filter">

                                    <tr>  
                                        <td>
                                            <h3>Daily Filter ({$start_date_ga} - {$end_date_ga})</h3>
                                        </td>

                                    </tr>

                                </table>
                            </form>

                            <form  >
                                <span class="ga_result">
                                    {include file="./pdf_ga_list_view.tpl"}
                                </span>
                            </form>
                        </span>

                    </span>

                    <span class="heading page_break">
                        <h1>Microsite Reports</h1> 
                    </span>

                    <span class="content"  id="cp_wrapper" style="width: 98%;"> 
                        <span class="kpis">
                            <form  >
                                <table class="filter">

                                    <tr>  
                                        <td>
                                            <h3>Current KPIs</h3>
                                        </td>

                                    </tr>

                                </table>
                            </form>
                            {foreach $kpis as $kpi}
                                <span class="kpi"  >
                                    <span>                                    
                                        <img src="{$kpi}" />

                                    </span>
                                </span>
                            {/foreach}
                        </span>

                                                <span class="data_div" style="margin-bottom: 15px;">
                                                    <form>
                                                        <table class="filter">
                                                            <tbody>
                                                                <tr>  
                                                                    <td>
                                                                        <h3>Overview Comparison</h3>
                                                                    </td>                        
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                        
                                                    <span id="db_compare">
                                                        <img style="margin-left: 15px;" width="1450" height="300" src="{base_url()}/statistics/admin_statistics/draw_compare_chart_type/db/{$campaign_id}" />
                                                    </span>

                    </span>

                    <span {if $db_page_break}class="page_break"{/if}>
                        <form  >
                            <table class="filter">

                                <tr>  
                                    <td>
                                        <h3>Daily Filter ({$start_date} - {$end_date})</h3>
                                    </td>

                                </tr>

                            </table>
                        </form>

                        <form >
                            <span class="db_result">
                                {include file="./pdf_db_list_view.tpl"}
                            </span>
                        </form>

                    </span>
                </span>
            </span>                
        </span>


        <!-- end #MainContent -->

        <span id="MainFooter">
            <p>Copyright 2012 by VNG Digital Advertising.</p>                
        </span>
        <!-- end #MainFooter -->            
        </span>

    </body>
</html>