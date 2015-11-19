{*

/**
 * PENGUIN FrameWork
 * @author hungtd <tdhungit@gmail.com> 0972014011
 * @copyright Tran Dinh Hung 2011
 * 
 * View Films
 * 
 * @package PenguinFW
 * @subpackage films
 * @version 1.0.0
 */

*}

<div class="heading">
    <h1>{lang('View Admin films')}</h1>

    <div class=buttons>
        <a href="{base_url()}users/admin_users/edit/{$data_view->id}" class="button"><span>{lang('Edit')}</span></a>
    </div>
</div>

<div class="content">
    <table class="list">
        <tbody>
            
            <tr>
                <td class="left head">{get_label('created')}</td>
                <td class="left">{pg_field_value($data_view->created, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('modified')}</td>
                <td class="left">{pg_field_value($data_view->modified, 'DATETIME')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('username')}</td>
                <td class="left">{pg_field_value($data_view->username, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('name')}</td>
                <td class="left">{pg_field_value($data_view->name, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('name_en')}</td>
                <td class="left">{pg_field_value($data_view->name_en, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('description')}</td>
                <td class="left">{pg_field_value($data_view->description, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('content')}</td>
                <td class="left">{pg_field_value($data_view->content, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('slug')}</td>
                <td class="left">{pg_field_value($data_view->slug, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('category')}</td>
                <td class="left">{pg_field_value($data_view->category, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('actor')}</td>
                <td class="left">{pg_field_value($data_view->actor, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('director')}</td>
                <td class="left">{pg_field_value($data_view->director, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('year')}</td>
                <td class="left">{pg_field_value($data_view->year, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('time')}</td>
                <td class="left">{pg_field_value($data_view->time, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('point_imdb')}</td>
                <td class="left">{pg_field_value($data_view->point_imdb, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('subtitle')}</td>
                <td class="left">{pg_field_value($data_view->subtitle, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('country')}</td>
                <td class="left">{pg_field_value($data_view->country, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('quality')}</td>
                <td class="left">{pg_field_value($data_view->quality, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('image')}</td>
                <td class="left">{pg_field_value($data_view->image, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('image_small')}</td>
                <td class="left">{pg_field_value($data_view->image_small, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('link_sub')}</td>
                <td class="left">{pg_field_value($data_view->link_sub, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('link_download')}</td>
                <td class="left">{pg_field_value($data_view->link_download, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('trailer')}</td>
                <td class="left">{pg_field_value($data_view->trailer, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('link_torrent')}</td>
                <td class="left">{pg_field_value($data_view->link_torrent, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('note')}</td>
                <td class="left">{pg_field_value($data_view->note, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('is_hot')}</td>
                <td class="left">{pg_field_value($data_view->is_hot, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('is_allow_comment')}</td>
                <td class="left">{pg_field_value($data_view->is_allow_comment, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('status')}</td>
                <td class="left">{pg_field_value($data_view->status, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('counter_view')}</td>
                <td class="left">{pg_field_value($data_view->counter_view, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('counter_vote')}</td>
                <td class="left">{pg_field_value($data_view->counter_vote, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('counter_like')}</td>
                <td class="left">{pg_field_value($data_view->counter_like, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('counter_comment')}</td>
                <td class="left">{pg_field_value($data_view->counter_comment, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('meta_keyword')}</td>
                <td class="left">{pg_field_value($data_view->meta_keyword, 'AREA')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('meta_description')}</td>
                <td class="left">{pg_field_value($data_view->meta_description, 'AREA')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('weight')}</td>
                <td class="left">{pg_field_value($data_view->weight, 'NUM')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('online')}</td>
                <td class="left">{pg_field_value($data_view->online, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('data1')}</td>
                <td class="left">{pg_field_value($data_view->data1, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('data2')}</td>
                <td class="left">{pg_field_value($data_view->data2, 'TEXT')}</td>
            </tr>

            <tr>
                <td class="left head">{get_label('data3')}</td>
                <td class="left">{pg_field_value($data_view->data3, 'TEXT')}</td>
            </tr>

        </tbody>
    </table>
</div>
