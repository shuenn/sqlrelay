<?php

namespace Shuenn\SQLRelay;

use PDO;
use Illuminate\Database\MySqlConnection;

class SqlRelayConnection extends MySqlConnection
{
   /**
     * Run a select statement against the database.
     *
     * @param  string  $query
     * @param  array  $bindings
     * @param  bool  $useReadPdo
     * @return array
     */
    public function select($query, $bindings = [], $useReadPdo = true)
    {

        return $this->run($query, $bindings, function ($query, $bindings) use ($useReadPdo) {
            if ($this->pretending()) {
                return [];
            }

            // For select statements, we'll simply execute the query and return an array
            // of the database result set. Each element in the array will be a single
            // row from the database table, and will either be an array or objects.
            $statement = $this->prepared($this->getPdoForSelect($useReadPdo)
                              ->prepare($query));

            $this->bindValues($statement, $this->prepareBindings($bindings));

            $statement->execute();

            $aResult = $statement->fetchAll();

            # 將resource型態轉換成string
            if(isset($aResult)) {
                foreach ($aResult as $index => $aRaw) {
                    foreach($aRaw as $key => $value) {
                        if(gettype($value) == "resource") {
                            $aResult[$index]->$key = stream_get_contents($value);
                        }
                    }
                }
            }
            
            return $aResult;
        });
    }


}
