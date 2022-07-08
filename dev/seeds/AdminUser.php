<?php

use Phinx\Seed\AbstractSeed;

class AdminUser extends AbstractSeed
{
    public function run()
    {
        $this->table('user')
            ->insert([
                'uuid' => 'usr_devadmin',
                'name' => 'Dev Administrator',
                'data' => '{}',
                'created' => time(),
                'created_by' => 'system',
                'updated' => time(),
                'updated_by' => 'system'
            ])
            ->save();
        $this->table('user_source')
            ->insert([
                'user_uuid' => 'usr_devadmin',
                'source' => 'cas',
                'provider' => 'dev',
                'provider_id' => 'admin',
                'created' => time()
            ])
            ->save();
        $this->table('user_group_membership')
            ->insert([
                'user_uuid' => 'usr_devadmin',
                'group_uuid' => 'admins'
            ])
            ->save();
    }
}
