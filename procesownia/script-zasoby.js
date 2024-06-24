$(document).ready(function() {
    // Nasłuchiwanie kliknięć na przyciskach nawigacyjnych
    $('#page1Btn').click(function() {
        loadContent(1);
    });

    $('#page2Btn').click(function() {
        loadContent(2);
    });

    $('#page3Btn').click(function() {
        loadContent(3);
    });

    // Funkcja do ładowania zawartości strony na podstawie kategorii
    function loadContent(category) {
        $.ajax({
            url: 'get_content.php',
            type: 'POST',
            data: { category: category },
            success: function(response) {
                if (category === 1) {
                    $('#page1Content').html(response);
                } else if (category === 2) {
                    $('#page2Content').html(response);
                } else if (category === 3) {
                    $('#page3Content').html(response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Błąd pobierania zawartości:', status, error);
            }
        });
    }
});