<div id="basic_load_list"></div>
<script type="text/javascript">
    function PagingAction(page, page_size){
        LoadData(page, page_size,'{base_url()}basic_view_demo/list_view_paging');
    }
    $(document).ready(function(){
        LoadFirstData(10, '{base_url()}basic_view_demo/list_view_paging');
    });
</script>