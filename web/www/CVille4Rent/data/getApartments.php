<!-- function to generate a list of apartments from an input -->
<?php
    function generateApartmentList($apartments) {
        $html = '<div class="list-group" aria-label="apartments">';
        foreach ($apartments as $apartment) {
            $html .= '<a href="apartment.php" class="list-group-item list-group-item-action">';
            $html .= '<h4>' . $apartment['name'] . '</h4>';
            $html .= '<ul class="list-group list-group-flush">';
            $html .= '<li class="list-group-item"><b>Address:</b> ' . $apartment['address'] . '</li>';
            $html .= '<li class="list-group-item"><b>Rent:</b> ' . $apartment['rent'] . '</li>';
            $html .= '<li class="list-group-item"><b>Bedrooms:</b> ' . $apartment['bedrooms'] . '</li>';
            $html .= '<li class="list-group-item"><b>Bathrooms:</b> ' . $apartment['bathrooms'] . '</li>';
            $html .= '</ul>';
            $html .= '</a>';
        }
        $html .= '</div>';
        return $html;
    }
?>