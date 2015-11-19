{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * LIST RESOURCE
 * 
 * @package PenguinFW
 * @subpackage Resource
 * @version 1.0.0
 */

*}
{foreach $resources as $resource}
    <div class="line">
        <a href="{base_url('modules/admin_module_relations/get_ajax_relation')}/{$resource.id}" class="JsClickLoad" name="JsReportRelation" title="{$resource.id}">{$resource.name}</a>        
    </div>
{/foreach}

{literal}
    <script tyle="text/javascript">
        jQuery(document).ready(function($) {
            $('a.JsClickLoad').livequery('click', function () {
                $('#JsReportMainResource').val($(this).attr('title'));
            });
        });
    </script>
{/literal}