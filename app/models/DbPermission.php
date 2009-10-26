<?php
/**
 * DbPermission
 *
 * @author Tomas Goldir <tomas.goldir@gmail.com>
 * @copyright Copyleft (@) http://www.gnu.org/copyleft
 * @package webcreatio
 */

class DbPermission extends Permission
{
	public function __construct()
	{
                $result = dibi::query('SELECT id, id_parent, role FROM :wc:roles ORDER BY id, id_parent');
                $roles = $result->fetchAssoc('id');
                unset($result);
                foreach ($roles as $role)
                        $this->addRole($role->role, is_null($role->id_parent) ? NULL : $roles[$role->id_parent]->role);
                unset($roles, $role);

                // definujeme role
                /*$this->addRole('guest');
                $this->addRole('member');
                $this->addRole('administrator', 'member');  // administrator je potomkem member*/

                // definujeme zdroje
                $this->addResource('file');
                $this->addResource('article');

                // pravidlo: host může jen prohlížet články
                $this->allow('guest', 'article', 'view');
                // pravidlo: člen může prohlížet vše, soubory i články
                $this->allow('member', Permission::ALL, 'view');
                // administrátor dědí práva od člena, navíc má právo vše editovat
                $this->allow('administrator', Permission::ALL, array('view', 'edit'));
	}
}
