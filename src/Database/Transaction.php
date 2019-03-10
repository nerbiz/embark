<?php

namespace Nerbiz\Embark\Database;

use Illuminate\Support\Facades\DB;

class Transaction
{
    /**
     * @var \Closure
     */
    protected $operations;

    /**
     * @param \Closure $operations The database operations to perform
     */
    public function __construct(\Closure $operations)
    {
        $this->operations = $operations;
    }

    /**
     * Run the database operations in a transaction
     * @return bool True on success (exception on failure)
     * @throws \Exception
     */
    public function runOperations(): bool
    {
        // Start the transaction
        DB::beginTransaction();

        try {
            // Try to run the operations and commit them
            ($this->operations)();
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            // Rollback the changes, then throw the exception
            DB::rollback();
            throw $exception;
        }
    }
}
