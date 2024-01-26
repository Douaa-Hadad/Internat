$(document).ready(function () {
    // Store references to the search box and results elements
    var $searchBox = $('#search');
    var $searchResults = $('#search-results');

    // Bind a keyup event to the search box
    $searchBox.keyup(function () {
        var search_term = $(this).val();

        if (search_term.trim() !== '') { // Check if search term is not empty
            $.ajax({
                url: `../includes/search.php?term=${search_term}&building=${currentBuilding}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var results = '';
                    if (data.length > 0) {
                        $.each(data, function (index, student) {
                            if (student.status === 'interne') {
                                results += '<div class="search-result" onclick="showPopupStudent(' + student.roomNumber + ')">';
                                results += '<img src="' + student.image + '" width="50">';
                                results += '<div> <span>' + student.label + '</span><br>';
                                results += '<span> Status: <span style="color:green; text-transform: capitalize;">' + student.status + '</span></span><br>';
                                results += '<span> Chambre: ' + student.roomNumber + '</span> </div>';
                                results += '</div>';
                            }
                            else {
                                results += '<div class="search-result" onclick="showStudentInfo(' + student.id + ')" >';
                                results += '<img src="' + student.image + '" width="50">';
                                results += '<div> <span>' + student.label + '</span><br>';
                                results += '<span> Status: <span style="color:red; text-transform: capitalize;">' + student.status + '</span></span> </div> <br>';
                                results += '</div>';
                            }
                        });
                        $searchResults.html(results).show();
                    } else {
                        results += '<div class="search-result">';
                        results += '<p>Makayn walo</p>';
                        results += '</div>';
                        $searchResults.html(results).show();
                    }
                }
            });
        } else { // Hide results if search term is empty
            $searchResults.hide();
        }
    });

    // Bind a click event to the document object
    $(document).click(function (event) {
        // Check if the click occurred outside of the search box and its results
        if (!$(event.target).is($searchBox) && !$(event.target).is($searchResults)) {
            $searchResults.hide();
            $('#search').val('');
        }
    });
});

$(document).ready(function () {
    "use strict";

    $('#search, .fa-search').mouseenter(function () {
        $('.logo').hide();
    });

    $('#search, .fa-search').mouseleave(function () {
        $('.logo').show();
    });

    $('.fa-bars').click(function () {
        $('.navbar').toggle();
        $(this).toggleClass('fa-times');
    });

    $('.navbar, .navbar a').click(function () {
        $('.navbar').hide();
        $('.fa-bars').removeClass('fa-times');
    });
})