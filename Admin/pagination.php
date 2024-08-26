<?php
function paginate($conn, $query, $perPage = 10) {
    // Get the total number of records
    $result = mysqli_query($conn, $query);
    $totalRecords = mysqli_num_rows($result);
    $totalPages = ceil($totalRecords / $perPage);

    // Get the current page number
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    // Calculate the offset
    $offset = ($currentPage - 1) * $perPage;

    // Modify the query to include LIMIT and OFFSET
    $query .= " LIMIT $offset, $perPage";

    // Execute the modified query
    $result = mysqli_query($conn, $query);

    // Generate pagination links
    $paginationLinks = '';
    if ($totalPages > 1) {
        $paginationLinks .= '<nav aria-label="Page navigation">';
        $paginationLinks .= '<ul class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? 'active' : '';
            $paginationLinks .= "<li class='page-item $activeClass'><a class='page-link' href='?page=$i'>$i</a></li>";
        }
        $paginationLinks .= '</ul>';
        $paginationLinks .= '</nav>';
    }

    return [$result, $paginationLinks];
}
?>
