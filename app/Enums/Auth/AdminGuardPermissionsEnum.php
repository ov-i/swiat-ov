<?php

namespace App\Enums\Auth;

use Spatie\Enum\Enum;

class AdminGuardPermissionsEnum extends Enum
{
    /**
     * @return array<string, string>
     */
    public static function values(): array
    {
        return [
            // Users permissions
            'userRead' => 'user-read',
            'userWrite' => 'user-write',
            'userUpdate' => 'user-update',
            'userDelete' => 'user-delete',
            'userRestore' => 'user-restore',
            'userForceDelete' => 'user-force-delete',
            'userAssignRole' => 'user-assign-role',
            'userAssignPermission' => 'user-assign-permission',
            'userRevokeLicense' => 'user-revoke-license',
            // Roles permissions
            'roleRead' => 'role-read',
            'roleWrite' => 'role-write',
            'roleUpdate' => 'role-update',
            'roleDelete' => 'role-delete',
            'roleRestore' => 'role-restore',
            'roleForceDelete' => 'role-force-delete',
            'roleAssignPermission' => 'role-assign-permission',
            'roleRevokePermission' => 'role-revoke-permission',
            // Permissions actions
            'permissionRead' => 'permission-read',
            'permissionWrite' => 'permission-write',
            'permissionUpdate' => 'permission-update',
            'permissionDelete' => 'permission-delete',
            'permissionRestore' => 'permission-restore',
            'permissionForceDelete' => 'permission-force-delete',
            // Licenses actions
            'licenseRead' => 'license-read',
            'licenseWrite' => 'license-write',
            'licenseUpdate' => 'license-update',
            'licenseDelete' => 'license-delete',
            'licenseRestore' => 'license-restore',
            'licenseForceDelete' => 'license-force-delete',
            'licenseAssignUser' => 'license-assign-user',
            // Site maps actions
            'siteMapRead' => 'site-map-read',
            'siteMapWrite' => 'site-map-write',
            'siteMapUpdate' => 'site-map-update',
            'siteMapDelete' => 'site-map-delete',
            'siteMapRestore' => 'site-map-restore',
            'siteMapForceDelete' => 'site-map-force-delete',
            // Posts (only) actions
            'postRead' => 'post-read',
            'postWrite' => 'post-write',
            'postUpdate' => 'post-update',
            'postDelete' => 'post-delete',
            'postRestore' => 'post-restore',
            'postForceDelete' => 'post-force-delete',
            // Post comments actions
            'postCommentRead' => 'post-comment-read',
            'postCommentWrite' => 'post-comment-write',
            'postCommentUpdate' => 'post-comment-update',
            'postCommentApprove' => 'post-comment-approve',
            'postCommentDelete' => 'post-comment-delete',
            'postCommentRestore' => 'post-comment-restore',
            'postCommentForceDelete' => 'post-comment-force-delete',
            // Post attachments actions
            'postAttachmentRead' => 'post-attachment-read',
            'postAttachmentAdd' => 'post-attachment-add',
            'postAttachmentUpdate' => 'post-attachment-update',
            'postAttachmentDelete' => 'post-attachment-delete',
            'postAttachmentRestore' => 'post-attachment-restore',
            'postAttachmentForceDelete' => 'post-attachment-force-delete',
        ];
    }

}
