$('#influencer').select2({
    closeOnSelect: false,
    delay: 1000,
    placeholder: selectAInfluencerText+"...",
    ajax: {
        cacheDataSource: [],
        url: path,
        method: 'get',
        dataType: 'json',
        delay: 1000,
        data: function (params) {
            influencerId = [];
            influencer = document.getElementsByClassName('id-data')
            for (let i in influencer) {
                influencerId.push(influencer[i].id)
            }
            return {
                term: params.term,
                id: params.id,
                platform_id: $('#platform_id').val(),
                influencer: influencerId,
            };
        },
        processResults: function (data) {
            // Transforms the top-level key of the response object from 'items' to 'results'
            return {
                results: data
            };
        },
    }, templateResult: template,
    templateSelection: template, language: {
        "noResults": function () {
            return "No Results Found";
        }
    },
    escapeMarkup: function (markup) {
        return markup;
    }
}).on('select2:select', function (e) {
    if (e.params.data.check_group) {
        groupError(e.params.data);
    } else {
        PlatformTemplate(e.params.data);
    }
});
function template(data) {
    if ($(data.html).length === 0) {
        return data.text;
    }
    return $(data.html);
}

p = [];
$(document).on('change', '#platform_id', function () {
    result_add = $(this).val().filter(x => !p.includes(x));
    result_remove = p.filter(x => !$(this).val().includes(x));
    p = $(this).val();
    ii = [];
    platform = document.getElementsByClassName('count')
    for (let i in platform) {
        id = platform[i].id
        l = $(`#${id}`).attr('data-platfrom')
        if (!p.includes(l)) {
            ii.push(id)
        }
    }
    ii = ii.filter(function (element) {
        return element !== undefined;
    });
    if (result_remove.length) {
        platformError(result_remove, ii)
    }
});

function platformUnSelected(data) {

    for (let i in data) {
        adCount = document.getElementById('ad-count');
        document.getElementById('influencer-count').innerText--;
        adCount.innerText = Math.ceil(Number(adCount.innerText) - Math.ceil(Number($(`#${data[i]}`).attr(`data-count-${data[i]}`))));
        $(`#${data[i]}`).remove();
    }
}

function PlatformTemplate(data) {
    $('#platform-all').append(data.div)
    adCount = document.getElementById('ad-count');
    adCount.innerText = Math.ceil(Number(adCount.innerText) + data.count);
    document.getElementById('influencer-count').innerText++;
}
function PlatformTemplates(data, platform_id) {
    for (let i in data) {
        $('#platform-all').append(data[i].div)
        adCount = document.getElementById('ad-count');
        adCount.innerText = Math.ceil(Number(adCount.innerText) + data[i].count);
        document.getElementById('influencer-count').innerText++;
    }
    platformSelectAdd([platform_id])
}

function rowDelete(id) {
    document.getElementById('influencer-count').innerText--;
    adCount = document.getElementById('ad-count');
    adCount.innerText = Math.ceil(Number(adCount.innerText) - Number($(`#${id}`).attr(`data-count-${id}`)));
    $(`#${id}`).remove();
}

function groupError(data) {
    // Delete button on click

    // SweetAlert2 pop up --- official ad_record reference: https://sweetalert2.github.io/
    Swal.fire({
        text:
            addingTheText + data.influencer + toThisListText +
            data.name_group +
            "?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Yes!",
        cancelButtonText: "No",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton:
                "btn fw-bold btn-active-light-primary",
        },
    }).then(function (result) {
        if (result.value) {
            PlatformTemplate(data);
        }
    });
}

function platformError(data, influencer) {
    // Delete button on click
    // SweetAlert2 pop up --- official ad_record reference: https://sweetalert2.github.io/
    Swal.fire({
        text:
        removeInfluencerText,
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Yes!",
        cancelButtonText: "No",
        customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton:
                "btn fw-bold btn-active-light-primary",
        },
    }).then(function (result) {
        if (result.value) {
            platformUnSelected(influencer);
        } else if (result.dismiss === "cancel") {
            platformSelectAdd(data)
        }
    });
}

function platformSelectAdd(data)
{
    p = $('#platform_id').val()
    p = p.concat(data[0]);
    $('#platform_id').val(p)
    $('#platform_id').select2({
        templateResult: template,
    })
}
