<?php
function check_xss($url) {
    $html = file_get_contents($url);
    $pattern = "/<script\b[^>]*>(.*?)<\/script>/";
    if (preg_match($pattern, $html)) {
        return true;
    } else {
        return false;
    }
}

$dork = $_POST['dork']; // Ambil input dari form
$search_url = "https://www.google.com/search?q=" . urlencode($dork);

$uris = file_get_contents($search_url);
preg_match_all('/<a href="([^"]+)" class="[^"]+"/', $uris, $matches);

$results = array();
foreach ($matches[1] as $match) {
    if (check_xss($match)) {
        $results[] = $match;
    }
}

if (count($results) > 0) {
    foreach ($results as $result) {
        echo $result . "<br>";
    }
} else {
    echo "Tidak ada URL yang terinfeksi XSS";
}
?>
