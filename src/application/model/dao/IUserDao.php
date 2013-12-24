<?php 

namespace application\model\dao;

interface IUserDao{

	public function selectAll();
	public function selectById($user);
	/*public function selectByEmailAndPasswordKey(User $user);
	public function updateById(User $user);
	public function inativate(User $user);*/
}?>