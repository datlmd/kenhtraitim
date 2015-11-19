{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * Edit Musics
 * 
 * @package PenguinFW
 * @subpackage musics
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('Edit Admin music singer categories')}</h1>

    <div class=buttons>
        <a href="javascript:void(0)" onClick="$('#FormEditMusics').submit();" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    {validation_errors()}


    <form action="" method="post" id="FormEditMusics">
        <input type="hidden" name="id" value="{$data_edit->id}" />
        <table class="list">
            <tbody>            

                <tr>
                    <td class="left">{get_label('name')}</td>
                    <td class="left"><input type="text" name="name" value="{$data_edit->name}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('description')}</td>
                    <td class="left"><input type="text" name="description" value="{$data_edit->description}" /></td>
                </tr>

                <tr>
                    <td class="left">{get_label('event')}</td>
                    <td class="left">
                        <select name="event_id" style="width: 210px;">       
                            <option value="">None</option>
                            {foreach $events as $event}
                                <option value="{$event.id}" {if $event.id eq $data_edit->event_id}selected{/if}>{$event.name}</option>
                            {/foreach}

                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="left">{get_label('slug')}</td>
                    <td class="left"><input type="text" name="slug" value="{$data_edit->slug}" /></td>
                </tr>
            </tbody>
        </table>
    </form>

</div>
