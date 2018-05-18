drop table if exists MovieActor, MovieDirector, MovieGenre, Review, MaxPersonID, MaxMovieID, Actor, Director, Movie;


create table Movie(
	id INT,
	title VARCHAR(100) NOT NULL,
	year INT,
	rating VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY (id),
	-- makes sure each id is unique and identifies movie (primary key)
	CHECK (title != '' AND title IS NOT NULL)
	-- make sure each movie has a title (CHECK)
) ENGINE=INNODB;

create table Actor(
	id INT,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	sex VARCHAR(6),
	dob DATE NOT NULL,
	dod DATE,
	PRIMARY KEY (id),
	-- makes sure each id is unique and identifies actor (primary key)
	CHECK(dob IS NOT NULL AND dob != '0000-00-00'),
	-- makes sure each actor was born (CHECK)
	CHECK(first != '' AND first IS NOT NULL)
	-- every actor needs at least a first name
) ENGINE=INNODB;

create table Director(
	id INT,
	last VARCHAR(20) NOT NULL,
	first VARCHAR(20) NOT NULL,
	dob DATE NOT NULL,
	dod DATE,
	PRIMARY KEY (id),
	-- makes sure each id is unique and identifies director (primary key)
	CHECK(dob IS NOT NULL AND dob != '0000-00-00'),
	-- makes sure each director was born (CHECK)
	CHECK(first != '' AND first IS NOT NULL)
	-- every director needs at least a first name
) ENGINE=INNODB;

create table MovieGenre(
	mid INT,
	genre VARCHAR(20) NOT NULL,
	FOREIGN KEY (mid) references Movie(id)
	-- makes sure references valid movie (referential)
) ENGINE=INNODB;

create table MovieDirector(
	mid INT,
	did INT,
	FOREIGN KEY (mid) references Movie(id),
	-- makes sure references valid movie (referential)
	FOREIGN KEY (did) references Director(id)
	-- makes sure references valid director (referential)
) ENGINE=INNODB;

create table MovieActor(
	mid INT,
	aid INT,
	role VARCHAR(50),
	FOREIGN KEY (mid) references Movie(id),
	-- makes sure references valid movie (referential)
	FOREIGN KEY (aid) references Actor(id)
	-- makes sure references valid actor (referential)
) ENGINE=INNODB;

create table Review(
	name VARCHAR(20) NOT NULL,
	time TIMESTAMP NOT NULL,
	mid INT,
	rating INT NOT NULL,
	comment VARCHAR(500),
	FOREIGN KEY (mid) references Movie(id),
	-- makes sure references valid movie (referential)
	CHECK(rating >= 0)
	-- makes sure rating is valid (CHECK)
) ENGINE=INNODB;

create table MaxPersonID(
	id INT
);

create table MaxMovieID(
	id INT
);