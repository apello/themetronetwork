
--create 3 tables
--find relationships between data in tables and between tables
/*

setup relationships
	- m to n (many users to many posts)
		- join table with foriegn keys -> primary keys ()
	- 1 to m (one user maps to many posts)
		- foreign key
	- 1 to 1 (profile for a user)
		- usually collapse into a single table

*/

-- 1 to 1 relationship

create table users (
	id serial primary key, 
	first_name text,
	last_name text,
	username varchar(255),
	email varchar(70) ,
	passwrd varchar(255),
	created_at date default now(),
	picture int,
	position int
);

-- 1 to m relationship

create table posts (
	id serial primary key,
	creatorid int references(users(id)),
	title text,
	body text default '...',
	community_ref int default NULL,
	created_at date default now()
);

-- now() - (random() - interval * '100 days')

-- m to n (many users to many posts)

create table comments (
	userid int references users(id),
	post_id int references post(id),
	comment varchar(255)
);

create table friends (
	created_at date 
	user_id1 int references users(id),
	user_id2 int references users(id),
	primary key (user_id1, user_id2)
);

create table favorites (
	userid int references users(id),
	postid int references posts(id),
	primary key (userid, postid)
);

create table class (
	id serial primary key,
	class_name text,
	class_proctor text.
	class_size int,

);

create table communities (
	userid int references users(id),
	class_id int references class(id),
	joined_at date default now()
);

-- insert information into the table

insert into users 
	(id, first_name, last_name, username, email) 
values 
	(default, "Abdirahman", "Nur", "username123", "email@email.com");

-- alter tables by column - add and drop

alter table users drop column last_name;
alter table users add column last_name text;

-- update row of information using condition

update users 
	set first_name = "Abdi" 
	where id = 1;

-- select info from table using condition

select * from users 
	where id = 1;

-- using inner join select all records (unless otherwise specified with a where clause) that having matching data in both tables

select first_name from users 
	inner join posts on users.id = posts.creatorid;

-- users.id = 1
-- posts.creatorid = 1
-- they are from same user

-- create aliases for table names to shorten code

select first_name, p.title from users u
	inner join posts p on u.id = p.creatorid;

-- rename aliases

select u.id user_id, p.id post_id, first_name, title from users u 
	inner join posts p on u.id = p.creatorid;

-- search info in db

select u.id user_id, from users u 
	inner join posts p on u.id = p.creatorid;
	where p.title like '%query%';

-- 'query%' <-- looks for if entry starts with word
-- '%query' <-- looks for if entry ends with word

-- feed 

select p.title, 
	substr(p.body, 1, 30), 
	u.first_name from posts p
	inner join users u on p.creatorid = u.id
	where created_at < now() + interval - 20 day
	order by created_at desc
	limit 20;

-- substr gives us a more managable piece of data - substr(column, start letter, end letter)
-- limit limits amount of posts - always at the end of statement
-- interval can add or subtract days from a date

select p.title,
	u.first_name,
	c.message,
	u2.first_name comment_creator
from posts p 
inner join users u on p.creatorid = u.id
inner join comments c on p.id = c.post_id
inner join users u2 on u2.id = c.user_id
where id = ?;

-- first inner join connect users and posts to find user first name using id
-- second inner join connects comments and posts to find comment using post id
-- third inner join connects users and comments to find user first name of the
-- commenter who commented using user id

select * from comments c
inner join users u on u.id = c.user_id
where post_id = ?;

-- if you were to split up

select count(*) from users;

-- cannot count and select other things
-- left join pulls all data from first table and matching data from second table - the result is NULL from right side if no matching results

select f.user_id is not null has_favorited -- alias for not null
from posts p 
left join favorites f
	on f.post_id = p.id and f.user_id = ?
where id = ?;

-- group by groups data using a column

select * from users;

select * from users u
inner join friends f on f.user_id1 = u.id;

-- counts how many friends user_id2 by counting user_id1 and grouping user_id2


select user_id2, 
		count(user_id1)
from friends 
group by user_id2;


-- count likes on posts

select post_id, count(*)
from favorites f 
inner join posts p on p.id = f.post_id
group by post_id
order by count(*) desc;

-- finds people who don't have friends
-- USE LEFT JOIN WHEN TRYING TO FIND NEGATIVES ie people who havent done sum or arent in the table

select count(*) from users u
left join friends f on
	f.user_id1 = u.id
		or f.user_id2 = u.id
where f.user_id1 is null;

--find people who have written posts

select count(*) from users u
inner join posts p on
	p.creatorid = u.id;

-- select count(distinct creatorid) from posts; finds how many individual people wrote a post regardless of if they wrote more than once

-- to create distinct feed per based on id

select * from posts p -- select posts from posts
inner join friends f -- join on friends table
	on (f.user_id1 = :post_creator_id or f.user_id2 = :post_creator_id) -- find out whether the post creator is a friend
	and (f.user_id1 = :id or f.user_id2 = :id); -- find out whether id = 1 is friends


-- comments
select * from comments c 
inner join posts p 
	on p.id = c.post_id
where post_id = 43



select c.class_name, --select the class name, teacher, and date joined
	c.class_proctor, 
	com.joined_at 
from class c -- from both class and communities
inner join communities com 
on 1 = com.userid and c.id = com.classid -- where the communities userid is 1 and the classid equals the communities

--delete from multiple tables
delete users, communities, posts, friends, favorites, comments --tables you want to delete from
from users  -- central table

inner join communities on users.id = communities.userid -- condition
inner join posts on users.id = posts.creatorid
inner join friends on (users.id = friends.user_id1 or users.id = friends.user_id2)
inner join favorites on users.id = favorites.user_id
inner join comments on users.id = comments.user_id

where users.id = 1; 

delete users, communities, posts, friends, favorites, comments 
from users 

inner join communities on users.id = communities.userid 
inner join posts on users.id = posts.creatorid
inner join friends on (users.id = friends.user_id1 or users.id = friends.user_id2)
inner join favorites on users.id = favorites.userid
inner join comments on users.id = comments.userid

where users.id = 2; 

-- example from website
DELETE T1, T2    
FROM    T1    
INNER JOIN T2    
ON T1.student_id=T2.student.id    
WHERE   T1.student_id=2;  