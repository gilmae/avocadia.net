<?php
    DB::registerQuery('find_all_quotes', "select * from quotes");
    DB::registerQuery('find_single_quote', 'select * from quotes where id = :id');
    DB::registerQuery('add_quote', "insert into quotes (quote, source) values (:quote, :source);");
?>