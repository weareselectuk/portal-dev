function wpsp_delete_company(id){
    
    if (confirm('Are you sure?')) {
        var data = {
            'action': 'wpsp_delete_company_by_id',
            'company_id': id
        };
        wpspjq.post(wpsp_company_data.wpsp_ajax_url, data, function (response) {
            window.location.reload();
        });
    }
}