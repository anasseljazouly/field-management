CREATE TABLE hotel (
  num_hotel int(11)  primary key,
  nom_hotel varchar(50) ,
  ville_hotel varchar(50),
  nombre_chambre int(11) ,
  coord_x double ,
  coord_y double 
);
CREATE TABLE chambre (
  num_chambre int(11)  ,
  num_hotel int(11),
  type_chambre varchar(50) ,
  capacite int(11) ,
  prix double,
  etage int(11) ,
   FOREIGN KEY (num_hotel) REFERENCES hotel(num_hotel),
   primary key (num_chambre,num_hotel)
);

CREATE TABLE Reservation_chambre (

  num_chambre int(11) ,
  num_hotel int(11) ,
  date_arriv date ,
  date_depart date ,
  FOREIGN KEY (num_hotel) REFERENCES hotel(num_hotel),
  FOREIGN KEY (num_chambre) REFERENCES chambre(num_chambre)
);
CREATE TABLE Spectacle (
  num_spec int(11) ,
  nom_spec varchar(20) ,
  date_spec date ,
  lieu_spec  varchar(20),
  nombre_place int(11),
  spec_x double,
  spec_y double,
  primary KEY (num_spec) 
);
insert into Reservation_chambre values 
(1,5,	"2008-1-11",	"2008-1-23",NULL),
(2,5,	"2008-1-11",	"2008-1-20",NULL);
(1,2,	"2008-1-11",	"2008-1-19"),
(1, 1 , "2007-12-11" , "2008-01-23"),
(2, 2 , "2007-12-11" , "2008-01-23"),
(3, 2 , "2008-02-20" , "2008-02-23");


insert into chambre values (1,1,'simple',5,300,2),
(2,1,'double',5,300,1),
(1,2,'simple',5,300,1),
(2,2,'simple',5,300,2),
(3,2,'simple',5,300,2),
(1,3,'double',5,250,1),;
insert into Spectacle values 
(5,"w1",	"2008-1-1","casa",200,0,300),
(6,"w2",	"2008-1-02","casa",200,100,1000),
(7,"w3",	"2008-1-3","casa",200,500,2000);

insert into hotel values 
(1,"farah",200,250,300,"casa"),
(2,"sofitel",300,500,1000,"rabat"),(3,"zzzzzz",20,250,3000,"casa"),(4,"rabatel",230,250,390,"rabat");


SET @S := "wee2";--nom de l'hotel
set @D := "2008-1-01";--date de l'hotel
SET @V := "casa";--nom de la ville
--question 1
select 
   nom_hotel,ch.num_chambre ,
   SQRT(POWER(H.coord_x-Spec.spec_x,2)+POWER(H.coord_y-Spec.spec_y,2)) as Distance
   from 
   Hotel as H,
   Chambre as Ch,
   Spectacle as Spec
   where 
   H.num_hotel=Ch.num_hotel and
   ch.num_chambre not in (
      select R.num_chambre
         from Reservation_chambre R
         where 
         R.num_chambre=ch.num_chambre and 
         ch.num_hotel=R.num_hotel and 
         @D between R.date_arriv and R.date_depart
   ) and
   Spec.nom_Spec = @S and
   Spec.date_Spec = @D 
   having
   Distance<500;

--question 2
select nom_hotel,ville from hotel as H 
 where num_hotel in
 (Select R.num_hotel from Reservation_chambre as R
 where @D between R.date_arriv and R.date_depart
having 
count(num_chambre)=H.nombre_chambre )
and ville=@V;

--question 3
select nom_hotel,ville,min(prix)
from (
   select nom_hotel,ville,prix
from hotel as H 
inner join 
chambre as ch 
on H.num_hotel=ch.num_hotel 
where H.ville=@V 
and ch.num_chambre not in (
      select R.num_chambre
         from Reservation_chambre R
         where 
         R.num_chambre=ch.num_chambre and 
         ch.num_hotel=R.num_hotel and 
         @D between R.date_arriv and R.date_depart
   )
group by ville , nom_hotel) A;
-- question 4
select C.* from client C where 
select ville where prix=max(prix);
select prix*3 from chambre where (num_chambre,num_hotel) in ( 
select *,datediff(date_depart,date_arriv)>3 as Dat from reservation_chambre having dat>3 );
select * from X where D1 not between date_depart and date_arriv 

select num_chambre,num_hotel from Reservation_chambre where D2<date_depart and d1>date_arriv;
select num_hotel,nom_hotel,ville,nom_spec from hotel H inner join spectacle S on H.ville=S.lieu_spec where date_Spec between @D1 and @D2 group by nom_spec,nom_hotel;



-- add in reservation le prix
-- question 5
alter table Reservation_chambre add column prix double ;
alter table Reservation_chambre add column num_reserv int(11) primary key ;

create table Reservation_place (num_reserv int(11),num_client int(11),num_place int(11),date_reservation date,prix double);
create table client (id_client int(11),nom_client varchar(50),prenom_client varchar(50),tel varchar(50),adress varchar(100));

insert into client values (1,"hamid","berada","068777777","hay inara"),(2,"mouad","adili","068799977","rabat rue 08");

select C.*,sum(prix) as total from client C,Reservation_chambre RC,Reservation_place RS,chambre ch where C.id_client=RC.num_client and C.id_client=RP.num_client and ch.num_chambre=RC.num_chambre  group by (id_client) having total>=5000 and ch.prix_nuit>1000; 




-- select min(prix)
-- from hotel as H 
-- inner join 
-- chambre as ch 
-- on H.num_hotel=ch.num_hotel 
-- where H.ville="casa" and prix=min(prix);
--  and ch.num_chambre not in (
--       select R.num_chambre
--          from Reservation_chambre R
--          where 
--          R.num_chambre=ch.num_chambre and 
--          ch.num_hotel=R.num_hotel and 
--          @D between R.date_arriv and R.date_depart
--    )

select ville from proposition_reservation as p where P.ville and date_debut between D1 and D2 and duree_sejour>3 having prix=max(prix) and count(Select id_spectacle from spectacle as S where S.date between P.date_debut and ADDDATE(P.date_debut,3) and S.ville=P.ville)>3; 
insert into ProposeSéjour values(1,2,"casa",5000,4,"2008-1-1");