/*
 * @package inventory
 */

Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'permissions',
        parent: 'catalogues',
        key: 'swag_demo',
        roles: {
            viewer: {
                privileges: [
                    'swag_demo:read',
                    'custom_field_set:read',
                    'custom_field:read',
                    'custom_field_set_relation:read',
                    Shopware.Service('privileges').getPrivileges('media.viewer'),
                    'user_config:read',
                    'user_config:create',
                    'user_config:update',
                ],
                dependencies: [],
            },
            editor: {
                privileges: [
                    'swag_demo:update',
                    Shopware.Service('privileges').getPrivileges('media.creator'),
                ],
                dependencies: [
                    'swag_demo.viewer',
                ],
            },
            creator: {
                privileges: [
                    'swag_demo:create',
                ],
                dependencies: [
                    'swag_demo.viewer',
                    'swag_demo.editor',
                ],
            },
            deleter: {
                privileges: [
                    'swag_demo:delete',
                ],
                dependencies: [
                    'swag_demo.viewer',
                ],
            },
        },
    });
