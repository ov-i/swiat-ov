<?php

namespace App\Enums\Auth;

use Spatie\Enum\Enum;

/**
 * Users
 * @method static self userIndex()
 * @method static self userRead()
 * @method static self userWrite()
 * @method static self userUpdate()
 * @method static self userDelete()
 * @method static self userRestore()
 * @method static self userForceDelete()
 * @method static self userAssignRole()
 * @method static self userAssignPermission()
 * @method static self userRevokeRole()
 * @method static self userRevokeLicense()
 * @method static self userBlockIndex()
 * @method static self userBlockRead()
 * @method static self userBlockWrite()
 * @method static self userBlockDelete()
 * @method static self userBlockForceDelete()
 * @method static self userBlockRestore()
 *
 * User post likes
 * @method static self userPostLike()
 *
 * Tokens
 * @method static self tokenIndex()
 * @method static self tokenRead()
 * @method static self tokenWrite()
 * @method static self tokenUpdate()
 * @method static self tokenDelete()
 * @method static self tokenForceDelete()
 * @method static self tokenRestore()
 *
 * Tickets
 * @method static self ticketIndex()
 * @method static self ticketRead()
 * @method static self ticketWrite()
 * @method static self ticketUpdate()
 * @method static self ticketDelete()
 * @method static self ticketForceDelete()
 * @method static self ticketRestore()
 *
 * Roles
 * @method static self roleIndex()
 * @method static self roleRead()
 * @method static self roleWrite()
 * @method static self roleUpdate()
 * @method static self roleDelete()
 * @method static self roleRestore()
 * @method static self roleForceDelete()
 * @method static self roleAssignPermission()
 * @method static self roleRevokePermission()
 *
 * Permissions
 * @method static self permissionIndex()
 * @method static self permissionRead()
 * @method static self permissionWrite()
 * @method static self permissionUpdate()
 * @method static self permissionDelete()
 * @method static self permissionRestore()
 * @method static self permissionForceDelete()
 *
 * Licenses
 * @method static self licenseIndex()
 * @method static self licenseRead()
 * @method static self licenseWrite()
 * @method static self licenseUpdate()
 * @method static self licenseDelete()
 * @method static self licenseRestore()
 * @method static self licenseForceDelete()
 * @method static self licenseAssignUser()
 *
 * Site maps
 * @method static self siteMapIndex()
 * @method static self siteMapRead()
 * @method static self siteMapWrite()
 * @method static self siteMapUpdate()
 * @method static self siteMapDelete()
 * @method static self siteMapRestore()
 * @method static self siteMapForceDelete()
 *
 * Posts
 * @method static self postIndex()
 * @method static self postRead()
 * @method static self postWrite()
 * @method static self postUpdate()
 * @method static self postDelete()
 * @method static self postRestore()
 *
 * Posts comment
 * @method static self postForceDelete()
 * @method static self postCommentRead()
 * @method static self postCommentWrite()
 * @method static self postCommentUpdate()
 * @method static self postCommentApprove()
 * @method static self postCommentDelete()
 * @method static self postCommentRestore()
 * @method static self postCommentForceDelete()
 *
 *
 * Post attachment
 * @method static self postAttachmentRead()
 * @method static self postAttachmentAdd()
 * @method static self postAttachmentUpdate()
 * @method static self postAttachmentDelete()
 * @method static self postAttachmentRestore()
 * @method static self postAttachmentForceDelete()
 */
class PermissionsEnum extends Enum
{
    /**
     * Gets all permissions without some exceptions.
     *
     * @param array<array-key, string> $basePermissions Base array permissions that should be filtered
     * @param array<array-key, string> $excepts Excluded permissions
     *
     * @return array<array-key, string>
     */
    public static function getAllExcept(array $basePermissions, array $excepts): array
    {
        return array_filter($basePermissions, function (string $permission) use ($excepts) {
            return !in_array($permission, $excepts, false);
        });
    }

    /**
     * Get base permissions as an user's permissions
     *
     * @return array<array-key, string>
     */
    public static function userPermissions(): array
    {
        return [
            PermissionsEnum::licenseRead()->value,
            PermissionsEnum::licenseUpdate()->value,
            PermissionsEnum::licenseWrite()->value,
            PermissionsEnum::userRevokeLicense()->value,
            PermissionsEnum::postIndex()->value,
            PermissionsEnum::postRead()->value,
            PermissionsEnum::userPostLike()->value,
            PermissionsEnum::userBlockRead()->value,
            PermissionsEnum::userBlockRead()->value,
            PermissionsEnum::postAttachmentRead()->value,
            PermissionsEnum::postCommentRead()->value,
            PermissionsEnum::postCommentWrite()->value,
            PermissionsEnum::siteMapRead()->value,
        ];
    }

    /**
     * Gets all permissions
     *
     * @return array<array-key, string>
     */
    public static function adminPermissions(): array
    {
        return self::toValues();
    }
}
