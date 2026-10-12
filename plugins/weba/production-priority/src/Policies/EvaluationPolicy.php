<?php

namespace Weba\ProductionPriority\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Weba\ProductionPriority\Models\Evaluation;
use Weba\ProductionPriority\Support\Abilities;
use Webkul\Security\Models\User;

/**
 * Evaluations are an audit trail: they can be created (run), viewed and
 * applied (update), but never deleted.
 */
class EvaluationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_production_priority_evaluation');
    }

    public function view(User $user, Evaluation $evaluation): bool
    {
        return $user->can('view_production_priority_evaluation');
    }

    public function create(User $user): bool
    {
        return $user->can('create_production_priority_evaluation');
    }

    public function update(User $user, Evaluation $evaluation): bool
    {
        return $user->can('update_production_priority_evaluation');
    }

    /**
     * Applying or reverting changes the priority of manufacturing orders, so it
     * is a decision of its own and not part of editing an evaluation.
     */
    public function apply(User $user, Evaluation $evaluation): bool
    {
        return $user->can(Abilities::APPLY_EVALUATION);
    }

    public function delete(User $user, Evaluation $evaluation): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }
}
