<?php
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RolePermissionSeeder.
 *
 * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/multiple-guards
 *
 * @package App\Database\Seeds
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Permission List as array
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    // admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                ]
            ],
            [
                'group_name' => 'address',
                'permissions' => [
                    // address Permissions
                    'address.create',
                    'address.view',
                    'address.edit',
                    'address.delete',
                ]
            ],
            [
                'group_name' => 'article',
                'permissions' => [
                    // article Permissions
                    'article.create',
                    'article.view',
                    'article.edit',
                    'article.delete',
                ]
            ],
             [
                'group_name' => 'category',
                'permissions' => [
                    // category Permissions
                    'category.create',
                    'category.view',
                    'category.edit',
                    'category.delete',
                ]
            ],

            [
                'group_name' => 'employe',
                'permissions' => [
                    // employe Permissions
                    'employe.create',
                    'employe.view',
                    'employe.edit',
                    'employe.delete',
                ]
            ],
            [
                'group_name' => 'position',
                'permissions' => [
                    // position Permissions
                    'position.create',
                    'position.view',
                    'position.edit',
                    'position.delete',
                ]
            ],
            [
                'group_name' => 'stock',
                'permissions' => [
                    // stock Permissions
                    'stock.view',
                    'stock.delete',
                ]
            ],
            [
                'group_name' => 'reception',
                'permissions' => [
                    // reception Permissions
                    'reception.create',
                    'reception.view',
                    'reception.edit',
                    'reception.show',
                    'reception.delete',
                    'reception.validate',
                    'reception.confirm',
                    'reception.approuve',
                    'reception.reset',
                    'reception.reject',
                ]
            ],
            [
                'group_name' => 'stockin',
                'permissions' => [
                    // stockin Permissions
                    'stockin.create',
                    'stockin.view',
                    'stockin.edit',
                    'stockin.show',
                    'stockin.delete',
                ]
            ],
            [
                'group_name' => 'stockout',
                'permissions' => [
                    // stockout Permissions
                    'stockout.create',
                    'stockout.view',
                    'stockout.edit',
                    'stockout.show',
                    'stockout.delete',
                ]
            ],
            [
                'group_name' => 'supplier',
                'permissions' => [
                    // supplier Permissions
                    'supplier.create',
                    'supplier.view',
                    'supplier.edit',
                    'supplier.delete',
                ]
            ],
             [
                'group_name' => 'setting',
                'permissions' => [
                    // setting Permissions
                    'setting.create',
                    'setting.view',
                    'setting.edit',
                    'setting.delete',
                ]
            ],
            [
                'group_name' => 'order',
                'permissions' => [
                    // order Permissions
                    'order.create',
                    'order.view',
                    'order.edit',
                    'order.delete',
                    'order.validate',
                    'order.confirm',
                    'order.approuve',
                    'order.reset',
                    'order.reject',
                ]
            ],
            [
                'group_name' => 'documents',
                'permissions' => [
                    // documents Permissions
                    'bon_entree.create',
                    'bon_sortie.create',
                    'bon_reception.create',
                    'facture.create',
                    'bon_commande.create',
                ]
            ],
            [
                'group_name' => 'inventory',
                'permissions' => [
                    // inventory Permissions
                    'inventory.view',
                    'inventory.create',
                    'inventory.edit',
                    'inventory.show',
                    'inventory.delete',
                    'inventory.validate',
                    'inventory.reset',
                    'inventory.reject',
                ]
            ],
            [
                'group_name' => 'invoice_drink',
                'permissions' => [
                    // invoice_drink Permissions
                    'invoice_drink.view',
                    'invoice_drink.create',
                    'invoice_drink.edit',
                    'invoice_drink.show',
                    'invoice_drink.delete',
                    'invoice_drink.validate',
                    'invoice_drink.reset',
                    'invoice_drink.reject',
                ]
            ],
            [
                'group_name' => 'invoice_kitchen',
                'permissions' => [
                    // invoice_kitchen Permissions
                    'invoice_kitchen.view',
                    'invoice_kitchen.create',
                    'invoice_kitchen.edit',
                    'invoice_kitchen.show',
                    'invoice_kitchen.delete',
                    'invoice_kitchen.validate',
                    'invoice_kitchen.reset',
                    'invoice_kitchen.reject',
                ]
            ],
            [
                'group_name' => 'order_kitchen',
                'permissions' => [
                    // order_kitchen Permissions
                    'order_kitchen.view',
                    'order_kitchen.create',
                    'order_kitchen.edit',
                    'order_kitchen.show',
                    'order_kitchen.delete',
                    'order_kitchen.validate',
                    'order_kitchen.reset',
                    'order_kitchen.reject',
                ]
            ],
            [
                'group_name' => 'order_drink',
                'permissions' => [
                    // order_drink Permissions
                    'order_drink.view',
                    'order_drink.create',
                    'order_drink.edit',
                    'order_drink.show',
                    'order_drink.delete',
                    'order_drink.validate',
                    'order_drink.reset',
                    'order_drink.reject',
                ]
            ],
            [
                'group_name' => 'report',
                'permissions' => [
                    // report Permissions
                    'report.view',
                    'report.edit',
                ]
            ],
            [
                'group_name' => 'profile',
                'permissions' => [
                    // profile Permissions
                    'profile.view',
                    'profile.edit',
                ]
            ],
        ];


        // Do same for the admin guard for tutorial purposes
        $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup, 'guard_name' => 'admin']);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }

        // Assign super admin role permission to superadmin user
        $admin = Admin::where('username', 'superadmin')->first();
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
    }
}
