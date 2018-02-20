<?php
    DEFINE("QUERIES", 
        [
        'find_all_quotes' => "select * from quotes",
        'find_single_quote' => 'select * from quotes where id = :id'
        ]
    );
?>