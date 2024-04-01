<!-- function to generate a list of apartments from an input -->
<?php
function generateApartmentList($apartments)
{
    $html = '';
    foreach ($apartments as $apartment) {
        $html .= '<a href="?command=apartment&name=' . $apartment['name'] . '" class="list-group-item list-group-item-action">';
        $html .= '<h4>' . $apartment['name'] . '</h4>';
        $html .= '<ul class="list-group list-group-flush">';
        $html .= '<li class="list-group-item"><b>Address:</b> ' . $apartment['address'] . '</li>';
        $html .= '<li class="list-group-item"><b>Rent:</b> ' . $apartment['rent'] . '</li>';
        $html .= '<li class="list-group-item"><b>Bedrooms:</b> ' . $apartment['bedrooms'] . '</li>';
        $html .= '<li class="list-group-item"><b>Bathrooms:</b> ' . $apartment['bathrooms'] . '</li>';
        $html .= '</ul>';
        $html .= '</a>';
    }
    return $html;
}
?>

<?php
function generateRatingsList($ratings)
{
    $html = '';
    foreach ($ratings as $rating) {
        $html .= '<a href="?command=apartment&name=' . $rating['apartment']['name'] . '" class="list-group-item list-group-item-action">';
        $html .= '<h4>' . $rating['title'] . '</h4>';
        $html .= '<ul class="list-group list-group-flush">';
        $html .= '<li class="list-group-item"><b>Apartment Name:</b> ' . $rating['apartment']['name'] . '</li>';
        $html .= '<li class="list-group-item"><b>Rent Paid:</b> ' . $rating['rentPaid'] . '</li>';
        $html .= '<li class="list-group-item"><b>Rating:</b> ' . $rating['rating'] . '</li>';
        $html .= '<li class="list-group-item"><b>Comment:</b> ' . $rating['comment'] . '</li>';
        $html .= '</ul>';
        $html .= '</a>';
    }
    return $html;
}
?>