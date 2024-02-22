$('#influencer').select2({
    dropdownParent: $("#exampleModal"),
    delay: 1000,
    placeholder: "{{getCustomTranslation('select_an_influencer')}}...",
    ajax: {
        cacheDataSource: [],
        url: search_influencer_url,
        method: 'get',
        dataType: 'json',
        delay: 1000,
        processResults: function (data) {
            // Transforms the top-level key of the response object from 'items' to 'results'
            return {
                results: $.map(data, function (item, index) {
                    return {
                        id: item.id,
                        text: item['name_'+"{{$lang}}"],
                    }
                }),
            };
        },
    }
});
