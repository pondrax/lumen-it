const collections = [
	{
		method :'POST',
		url : 'api/auth/login',
		body : {
			username : 'drax',
			password : 'lumen123'
		}
	},
	{
		method :'POST',
		url : 'api/auth/register',
		body : {
			username : 'test',
			email	 : 'test@mail.com',
			password : 'lumen123',
		}
	},
	{
		method :'GET',
		url : 'api/app/role/all?limit=5&page=1&sort=id&order=desc',
	},
	{
		method :'GET',
		url : 'api/app/user/all?limit=5&page=1&sort=id&order=desc',
	},
	{
		method :'GET',
		url : 'api/app/menu/all?limit=5&page=1&sort=id&order=desc',
	},
	{
		method :'GET',
		url : 'api/app/route/all?limit=5&page=1&sort=id&order=desc',
	},
	{
		method :'GET',
		url : 'api/app/access/all?limit=5&page=1&sort=id&order=desc',
	},
	{
		method :'GET',
		url : 'api/app/logs/all?limit=5&page=1&sort=id&order=desc',
	}
];
