function startPDFparsing(pages) {

    $(function () {
        var docHeight = $(document).height();
        $('body').append("<div id='overlay'></div>");
        $('#overlay')
            .height(docHeight)
            .css({
                'opacity': 0.7,
                'position': 'absolute',
                'top': 0,
                'left': 0,
                'background-color': 'black',
                'width': '100%',
                'z-index': 5000
            });
        $('body').append(
            "<div class = 'windowProgress'><b>Обработка PDF-документа</b><br>Пожалуйста, не закрывайте и не обновляйте страницу, пока идет загрузка документа." +
            "<br/><br/><img src='images/pdf.gif'>" +
            "<div id='myProgress'>" +
            "<div id='myBar'></div>" +
            "</div>");
        parsing();


    });

    let progress = 0;

    function parsing() {
        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            url: '../upload_multiplePDF.php',
            dataType: 'json',
            success: function (response) {

                //показываем ответ
                if (response.type === 'upload_in_progress') {

                    //получаем процент обработки
                    progress = response.msg;

                    //парсим все страницы по очереди
                    if (progress <= 100) {
                        parsing();
                        move(progress);
                        // $("#server-response").html('<div class = success>' + response.result + '</div>');
                        $("#server-response").append("<div class = 'success'>" + response.result + '</div>');
                        var docHeight = $(document).height();
                        $('#overlay').css.height(docHeight);
                        /*$("#server-response").css({
                            'display' : 'flex',
                            'flex':'auto',
                            'margin':'25px'
                        })

                         */
                    }
                    if (progress === 100) {

                        $('#overlay').hide();
                        $('.windowProgress').hide();

                    }

                } else {
                    alert('Что-то пошло не так. Попробуйте еще раз.');
                }
            },
        });
    }

    function move(progress){
        var bar = document.getElementById("myBar");
            bar.style.width = progress +'%';

    }
}




