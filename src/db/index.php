<?php
/**
 * Connect to DB
 */

/** @var \PDO $pdo */
require_once './pdo_ini.php';

/**
 * SELECT the list of unique first letters using https://www.w3resource.com/mysql/string-functions/mysql-left-function.php
 * and https://www.w3resource.com/sql/select-statement/queries-with-distinct.php
 * and set the result to $uniqueFirstLetters variable
 */
$sth = $pdo->prepare('SELECT DISTINCT LEFT(name, 1) AS letter FROM airports ORDER BY letter');
$sth->setFetchMode(\PDO::FETCH_NUM);
$sth->execute();
$res = $sth->fetchAll();
foreach ($res as $item){
    $uniqueFirstLetters[]=$item[0];
}

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 *
 * For filtering by first_letter use LIKE 'A%' in WHERE statement
 * For filtering by state you will need to JOIN states table and check if states.name = A
 * where A - requested filter value
 */
$query = "SELECT a.name, a.code, s.name AS 'state_name', c.name AS 'city_name',  a.address, a.timezone
FROM airports a
LEFT JOIN states s ON a.state_id = s.id
LEFT JOIN cities c ON a.city_id = c.id";

if (!empty($_GET['filter_by_first_letter']) || !empty($_GET['filter_by_state']) ) {
    $query.= " WHERE ";
}

if (!empty($_GET['filter_by_first_letter'])) {
    $query.= "a.name LIKE " . "'" . $_GET['filter_by_first_letter'] . "%'";
}

if (!empty($_GET['filter_by_state'])) {
    if (!empty($_GET['filter_by_first_letter'])){
        $query.= " AND ";
    }
    $query.= "s.name = " . " '" . $_GET['filter_by_state'] . "'";
}

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 *
 * For sorting use ORDER BY A
 * where A - requested filter value
 */
if (!empty($_GET['sort'])) {
    $query .= " ORDER BY {$_GET['sort']}";
}

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 *
 * For pagination use LIMIT
 * To get the number of all airports matched by filter use COUNT(*) in the SELECT statement with all filters applied
 */
const PER_PAGE = 5;
const MID_SIZE = 3;

$currentPage = $_GET['page'] ?? 1;
$offset = ($currentPage - 1) * PER_PAGE;

if (!empty($_GET["sort"])){
    $subQuery = "SELECT COUNT(*) " . stristr(stristr ( $query , 'ORDER', true), 'FROM');
} else {
    $subQuery = "SELECT COUNT(*) " . stristr ($query , 'FROM');
}

$count = $pdo->prepare($subQuery);
$count->setFetchMode(\PDO::FETCH_ASSOC);
$count->execute();
$allPages = $count->fetchAll();
$totalPages = ceil($allPages[0]["COUNT(*)"] / PER_PAGE);

$back = '';
$forward = '';
$start_page = '';
$end_page = '';
$pages_left = '';
$pages_right = '';

if ($currentPage > 1) {
    $urlQuery = http_build_query(array_merge($_GET, ['page' => $currentPage - 1]));
    $back = "<li class='page-item'><a class='page-link' href='?" . $urlQuery . "'>&lt;</a></li>";
}

if ($currentPage < $totalPages) {
    $urlQuery = http_build_query(array_merge($_GET, ['page' => $currentPage + 1]));
    $forward = '<li class="page-item"><a class="page-link" href="?' . $urlQuery . '">&gt;</a></li>';
}

if ($currentPage > MID_SIZE + 1) {
    $urlQuery = http_build_query(array_merge($_GET, ['page' => 1]));
    $start_page = "<li class='page-item'><a class='page-link' href='?" . $urlQuery . "'>&laquo;</a></li>";
}

if ($currentPage < ($totalPages - MID_SIZE)) {
    $urlQuery = http_build_query(array_merge($_GET, ['page' => $totalPages]));
    $end_page = "<li class='page-item'><a class='page-link' href='?" . $urlQuery . "'>&raquo;</a></li>";
}

for ($i = MID_SIZE; $i > 0; $i--) {
    if ($currentPage - $i > 0) {
        $urlQuery = http_build_query(array_merge($_GET, ['page' => $currentPage - $i]));
        $pages_left .= "<li class='page-item'><a class='page-link' href='?" . $urlQuery . "'>" . $currentPage - $i . "</a></li>";
    }
}

for ($i = 1; $i <= MID_SIZE; $i++) {
    if ($currentPage + $i <= $totalPages) {
        $urlQuery = http_build_query(array_merge($_GET, ['page' => $currentPage + $i]));
        $pages_right .= "<li class='page-item'><a class='page-link' href='?" . $urlQuery . "'>" . $currentPage + $i . "</a></li>";
    }
}
/**
 * Build a SELECT query to DB with all filters / sorting / pagination
 * and set the result to $airports variable
 *
 * For city_name and state_name fields you can use alias https://www.mysqltutorial.org/mysql-alias/
 */
$query.= " LIMIT " . PER_PAGE . " OFFSET $offset";

$sth = $pdo->prepare($query);
$sth->setFetchMode(\PDO::FETCH_ASSOC);
$sth->execute();
$airports = $sth->fetchAll();
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

        <?php foreach ($uniqueFirstLetters as $letter): ?>
            <a href="?<?= http_build_query(array_merge($_GET, ['filter_by_first_letter' => $letter], ['page' => 1])) ?>"><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="<?=$_SERVER["PHP_SELF"]?>" class="float-right">Reset all filters</a>
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
            <th scope="col"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'state_name'])) ?>">State</a></th>
            <th scope="col"><a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'city_name'])) ?>">City</a></th>
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
                <a href="?<?= http_build_query(array_merge($_GET, ['filter_by_state' => $airport['state_name']], ['page' => 1])) ?>">
                    <?= $airport['state_name'] ?>
                </a>
            </td>
            <td><?= $airport['city_name'] ?></td>
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
