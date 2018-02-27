<?php
    class DB
    {
        private static $queries = [];

        function __call($sql, $args)
        {
            return $this->query(self::$queries[$sql], $args);
        }

        public static function registerQuery($name, $querySpec)
        {
            self::$queries[$name] = $querySpec;
        }
        
        private function Query($sql, $args)
        {
            $pdo = $this->getConnection();

            $stmt = $pdo->prepare($sql);
            if (empty($args))
            {
                $stmt->execute();
            }
            else
            {
                $stmt->execute($args[0]);
            }
            
            $records = [];
            while ($row = $stmt->fetch())
            {
                array_push($records, (object)$row);
            }
            return $records;
        }

        private function getConnection()
        {
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;

            return new PDO($dsn, DB_UID, DB_PWD, $opt);
        }
    }
?>