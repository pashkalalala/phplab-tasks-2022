<?php
require_once './functions.php';

$airports = require './airports.php';

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 */
if (!empty($_GET['filter_by_first_letter'])) {
    $airports = filteringByFirstLetter($airports, $_GET['filter_by_first_letter']);
}

if (!empty($_GET['filter_by_state'])) {
    $airports = filteringByState($airports, $_GET['filter_by_state']);
}

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 */
if (!empty($_GET['sort'])) {
    $airports = sortByColumn($airports, $_GET['sort']);
}

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 */
const PER_PAGE = 5;
const MID_SIZE = 3;

$totalPages = ceil(count($airports) / PER_PAGE);
$currentPage = $_GET['page'] ?? 1;
$start = ($currentPage - 1) * PER_PAGE;
$airports = array_slice($airports, $start, PER_PAGE);

$back = '';
$forward = '';
$start_page = '';
$end_page = '';
$pages_left = '';
$pages_right = '';

if ($currentPage > 1) {
    $query = http_build_query(array_merge($_GET, ['page' => $currentPage - 1]));
    $back = "<li class='page-item'><a class='page-link' href='?" . $query . "'>&lt;</a></li>";
}

if ($currentPage < $totalPages) {
    $query = http_build_query(array_merge($_GET, ['page' => $currentPage + 1]));
    $forward = '<li class="page-item"><a class="page-link" href="?' . $query . '">&gt;</a></li>';
}

if ($currentPage > MID_SIZE + 1) {
    $query = http_build_query(array_merge($_GET, ['page' => 1]));
    $start_page = "<li class='page-item'><a class='page-link' href='?" . $query . "'>&laquo;</a></li>";
}

if ($currentPage < ($totalPages - MID_SIZE)) {
    $query = http_build_query(array_merge($_GET, ['page' => $totalPages]));
    $end_page = "<li class='page-item'><a class='page-link' href='?" . $query . "'>&raquo;</a></li>";
}

for ($i = MID_SIZE; $i > 0; $i--) {
    if ($currentPage - $i > 0) {
        $query = http_build_query(array_merge($_GET, ['page' => $currentPage - $i]));
        $pages_left .= "<li class='page-item'><a class='page-link' href='?" . $query . "'>" . $currentPage - $i . "</a></li>";
    }
}

for ($i = 1; $i <= MID_SIZE; $i++) {
    if ($currentPage + $i <= $totalPages) {
        $query = http_build_query(array_merge($_GET, ['page' => $currentPage + $i]));
        $pages_right .= "<li class='page-item'><a class='page-link' href='?" . $query . "'>" . $currentPage + $i . "</a></li>";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
    -->
    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach (getUniqueFirstLetters(require './airports.php') as $letter): ?>
            <a href="?<?= http_build_query(array_merge($_GET, ['filter_by_first_letter' => $letter], ['page' => 1])) ?>"><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="<?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?>" class="float-right">Reset all filters</a>
    </div>

    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
    -->
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'name'])) ?>">Name</a></th>
            <th scope="col"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'code'])) ?>">Code</a></th>
            <th scope="col"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'state'])) ?>">State</a></th>
            <th scope="col"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'city'])) ?>">City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <!--
            Filtering task #2
            Replace # in HREF so that link follows to the same page with the filter_by_state key
            i.e. /?filter_by_state=A or /?filter_by_state=B

            Make sure, that the logic below also works:
             - when you apply filter_by_state the page should be equal 1
             - when you apply filter_by_state, than filter_by_first_letter (see Filtering task #1) is not reset
               i.e. if you have filter_by_first_letter set you can additionally use filter_by_state
        -->
        <?php foreach ($airports as $airport): ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td>
                <a href="?<?= http_build_query(array_merge($_GET, ['filter_by_state' => $airport['state']], ['page' => 1])) ?>">
                    <?= $airport['state'] ?>
                </a>
            </td>
            <td><?= $airport['city'] ?></td>
            <td><?= $airport['address'] ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!--
        Pagination task
        Replace HTML below so that it shows real pages dependently on number of airports after all filters applied

        Make sure, that the logic below also works:
         - show 5 airports per page
         - use page key (i.e. /?page=1)
         - when you apply pagination - all filters and sorting are not reset
    -->
    <nav aria-label="Navigation">
        <ul class="pagination justify-content-center">
            <?php echo $start_page ?>
            <?php echo $back ?>
            <?php echo $pages_left ?>
            <li class="page-item active"><a class="page-link"><?php echo $currentPage ?></a></li>
            <?php echo $pages_right ?>
            <?php echo $forward ?>
            <?php echo $end_page ?>
        </ul>
    </nav>
</main>
</html>
