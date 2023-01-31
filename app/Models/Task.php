<?php
declare(strict_types = 1);

namespace App\Models;

use App\Events\TaskCompleted;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'deadline',
        'completed',
        'user_id'
    ];

    /**
     * Get the user that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toggleStatus(): Task
    {
        $this->completed = $this->completed == false;
        $this->save();
        TaskCompleted::dispatch($this);
        return $this;
    }

    public function filterByQueryParams(array $params, User $user): Collection
    {
        return $this->select(['id', 'name', 'deadline', 'completed'])
            ->when(isset($params['deadlineFrom']),
                function($query) use ($params) {
                    $query->where('deadline', '>=', $params['deadlineFrom']);
                })
            ->when(isset($params['deadlineTo']),
                function ($query) use ($params) {
                    $query->where('deadline', '<=', $params['deadlineTo']);
                })
            ->when(isset($params['name']),
                function ($query) use ($params) {
                    $query->where('name', 'LIKE', "%{$params['name']}%");
                })
            ->when(isset($params['search']),
                function ($query) use ($params) {
                    $query->where('description', 'LIKE', "%{$params['search']}%");
                })
            ->where('user_id', '=', $user->id)
            ->when(isset($params['sortBy']) && strpos($params['sortBy'], 'asc'),
                function($query) use ($params) {
                    $query->orderBy(explode('_', $params['sortBy'])[0], 'asc');
                })
            ->when(isset($params['sortBy']) && strpos($params['sortBy'], 'desc'),
                function($query) use ($params) {
                    $query->orderBy(explode('_', $params['sortBy'])[0], 'Desc');
                })
            ->get();
    }
}
