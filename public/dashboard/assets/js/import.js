let import_status = 0;
document.forms["myForm"].addEventListener("submit", async (event) => {
    event.preventDefault();
    let error = false;
    $("#loading-button").removeClass("d-none");
    $("#submit-button").addClass("d-none");
    $('.download_link').hide();
    try {
        const resp = await fetch(event.target.action, {
            method: "POST",
            body: new FormData(event.target),
        });
        const body = await resp.json();
        if(body.error){
            error = true;
        }
    }catch (e) {
    }
    if(error){
        alert("you must import the file first.");
        import_status = 1;
        $("#submit-button").removeClass("d-none");
        $("#loading-button").addClass("d-none");
        $('.download_link').show();
    }else {
        import_status = 0;
        alert("importing is in progress please wait.");
    }
    RepeatFun();
});
function RepeatFun() {
    setInterval(function () {
        if (import_status == 1) {
        } else {
            $.ajax({
                url: status_url,
            }).done(function (data) {
                if (data.done == 1) {
                    import_status = 1;
                    $("#submit-button").removeClass("d-none");
                    $("#loading-button").addClass("d-none");
                    alert(
                        "importing is done successfully, it may take some time to see all the data."
                    );
                    $('.download_link').show();
                    $('#submit-button').prop("disabled", false); // Element(s) are now enabled.
                    location.reload()
                }
            }).fail(function (data) {
            });
        }
    }, 6000);
}
;