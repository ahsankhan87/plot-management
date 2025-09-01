<?php

use App\Models\AuditLogModel;

if (!function_exists('logAudit')) {
    /**
     * Logs an audit entry for actions performed by users.
     *
     * @param string $action The action being logged (e.g., 'CREATE', 'UPDATE', 'DELETE').
     * @param string $module The module where the action occurred (e.g., 'Auth', 'Payments').
     * @param mixed $recordId The ID of the record being affected, if applicable.
     * @param array $oldData The old data before the action, if applicable.
     * @param array $newData The new data after the action, if applicable.
     */
    function logAudit(string $action, string $module, $recordId = null, $oldData = [], $newData = [])
    {
        $audit = new AuditLogModel();

        // Detect changed fields only (diff)
        $changesOld = [];
        $changesNew = [];

        foreach ($newData as $field => $newValue) {
            $oldValue = $oldData[$field] ?? null;
            if ($oldValue !== $newValue) {
                $changesOld[$field] = $oldValue;
                $changesNew[$field] = $newValue;
            }
        }

        $audit->insert([
            'user_id'    => session()->get('user_id'),
            'action'     => $action,
            'module'     => $module,
            'record_id'  => $recordId,
            'old_data'   => json_encode($changesOld, JSON_UNESCAPED_UNICODE),
            'new_data'   => json_encode($changesNew, JSON_UNESCAPED_UNICODE),
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getUserAgent(),

        ]);
    }
}
