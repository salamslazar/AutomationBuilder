<?php

namespace App\Jobs;

use App\Models\ExecutionLog;
use App\Models\Workflow;
use App\Models\XTable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class ExecuteWorkflowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $workflow;
    protected $payload;

    /**
     * Create a new job instance.
     */
    public function __construct(Workflow $workflow, $payload = null)
    {
        $this->workflow = $workflow;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $conditions = $this->workflow->conditions;
        if(! $this->checkConditions($conditions['criteria'])){
            $this->logExecution(false, 'Conditions not met');
            return;
        }

        foreach($this->workflow->actions as $action){
            $result = $this->performAction($action);
        }

        $this->logExecution($result, 'executed');
    }

    protected function checkConditions($conditionString)
    {
        $splitedConditionString = explode('AND', $conditionString);

        $conditions = array();
        foreach ($splitedConditionString as $condition) {
            $condition = trim($condition, '()');
            preg_match("/(\w+)\s*(=|<|>|!=)\s*'([^']+)'/", $condition, $matches);

            $field = $matches[1];
            $operator = $matches[2];
            $value = $matches[3];

            //$conditions[] = array('field' => $matches[1], 'operator' => $matches[2], 'value' => $matches[3]);
            $fieldValue = data_get($this->payload, $field);

            if (!$this->compare($fieldValue, $operator, $value)) {
                return false; 
            }
        }

        return true;
    }

    protected function compare($field, $operator, $value)
    {
        switch ($operator) {
            case '=':
                return $field == $value;
            case '>':
                return $field > $value;
            case '<':
                return $field < $value;
            case 'like':
                return stripos($field, $value) !== false;
            default:
                return false;
        }
    }

    protected function performAction($action){
        switch ($action->name){
            case 'log':
                Log::info(" {$this->workflow->name} executed for new '{$this->payload->name}' in MyTable");
                break;
            case 'insert':
                XTable::create([
                    'name' => "MyTable new record name {$this->payload->name}",
                    'my_table_id' => $this->payload->id
                ]);
                break;
        }
        return true;
    }

    protected function logExecution($result, $details)
    {
        ExecutionLog::create([
            'workflow_id' => $this->workflow->id,
            'result' => $result,
            'details' => $details,
        ]);
    }
}
