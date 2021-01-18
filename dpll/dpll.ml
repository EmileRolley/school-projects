open List

(* fonctions utilitaires *********************************************)

(* filter_map : ('a -> 'b option) -> 'a list -> 'b list
   disponible depuis la version 4.08.0 de OCaml dans le module List :
   pour chaque élément de `list', appliquer `filter' :
   - si le résultat est `Some e', ajouter `e' au résultat ;
   - si le résultat est `None', ne rien ajouter au résultat.
   Attention, cette implémentation inverse l'ordre de la liste *)
let filter_map filter list =
  let rec aux list ret =
    match list with
    | []   -> ret
    | h::t -> match (filter h) with
      | None   -> aux t ret
      | Some e -> aux t (e::ret)
  in aux list []

(* print_modele : int list option -> unit
   affichage du résultat *)
let print_modele: int list option -> unit = function
  | None   -> print_string "UNSAT\n"
  | Some modele -> print_string "SAT\n";
     let modele2 = sort (fun i j -> (abs i) - (abs j)) modele in
     List.iter (fun i -> print_int i; print_string " ") modele2;
     print_string "0\n"

(* ensembles de clauses de test *)
let exemple_3_12 = [[1;2;-3];[2;3];[-1;-2;3];[-1;-3];[1;-2]]
let exemple_7_2 = [[1;-1;-3];[-2;3];[-2]]
let exemple_7_4 = [[1;2;3];[-1;2;3];[3];[1;-2;-3];[-1;-2;-3];[-3]]
let exemple_7_8 = [[1;-2;3];[1;-3];[2;3];[1;-2]]
let systeme = [[-1;2];[1;-2];[1;-3];[1;2;3];[-1;-2]]
let dependances = [[1];[-1;2];[-1;3;4;5];[-2;6];[-3;7];[-4;8;9];[-4;9];[-9;-6];[-9;-7];[-4;-5];[-8;-9];[-6;-7]]
let coloriage = [[1;2;3];[4;5;6];[7;8;9];[10;11;12];[13;14;15];[16;17;18];[19;20;21];[-1;-2];[-1;-3];[-2;-3];[-4;-5];[-4;-6];[-5;-6];[-7;-8];[-7;-9];[-8;-9];[-10;-11];[-10;-12];[-11;-12];[-13;-14];[-13;-15];[-14;-15];[-16;-17];[-16;-18];[-17;-18];[-19;-20];[-19;-21];[-20;-21];[-1;-4];[-2;-5];[-3;-6];[-1;-7];[-2;-8];[-3;-9];[-4;-7];[-5;-8];[-6;-9];[-4;-10];[-5;-11];[-6;-12];[-7;-10];[-8;-11];[-9;-12];[-7;-13];[-8;-14];[-9;-15];[-7;-16];[-8;-17];[-9;-18];[-10;-13];[-11;-14];[-12;-15];[-13;-16];[-14;-17];[-15;-18]]

(* fonctions de debuggage *********************************************)

(* print_clauses : int list list -> unit
   Affichage d'un ensemble de clauses. *)
let print_clauses clauses =
  if [] = clauses then
    print_string "Vide"
  else
    print_string "[ ";
    List.iter
      (fun clause ->
        print_string "[ ";
        List.iter (fun l -> print_int l; print_string " ") clause;
        print_string "]";
      )
      clauses;
    print_string " ]\n"

(********************************************************************)

(* simplifie : int -> int list list -> int list list
   applique la simplification de l'ensemble des clauses en mettant
   le littéral i à vrai. *)
let rec simplifie i = function
  | [] -> []
  | clause :: clauses_restantes ->
      (* Si une clause contient le littéral i évalué à vrai, elle est supprimée. *)
      if mem i clause then simplifie i clauses_restantes
      (* Sinon les littéraux évalués à NOT(i) sont supprimés. *)
      else (List.filter (fun l -> l <> -i) clause) :: (simplifie i clauses_restantes)

(* solveur_split : int list list -> int list -> int list option
   exemple d'utilisation de `simplifie' *)
let rec solveur_split clauses interpretation =
  (* l'ensemble vide de clauses est satisfiable *)
  if clauses = [] then Some interpretation else
  (* une clause vide est insatisfiable *)
  if mem [] clauses then None else
  (* branchement *)
  let l = hd (hd clauses) in
  let branche = solveur_split (simplifie l clauses) (l::interpretation) in
  match branche with
  | None -> solveur_split (simplifie (-l) clauses) ((-l)::interpretation)
  | _    -> branche

(* tests *)
(* let () = print_clauses exemple_7_2 *)
(* let () = print_string "simplifie par 1\n"*)
(* let () = print_clauses (simplifie 1 exemple_7_2) *)
(* let () = print_string "simplifie par -2\n" *)
(* let () = print_clauses (simplifie (-2) (exemple_7_2)) *)
(* let () = print_string "simplifie par 1\n" *)
(* let () = print_clauses (simplifie 1 exemple_7_2) *)
(* let () = print_string "simplifie par -2\n" *)
(* let () = print_clauses (simplifie (-2) (simplifie 1 exemple_7_2)) *)
(* let () = print_modele (solveur_split exemple_7_8 []) *)
(* let () = print_modele (solveur_split systeme []) *)
(* let () = print_modele (solveur_split dependances []) *)
(* let () = print_modele (solveur_split coloriage []) *)

(* solveur dpll récursif *)

(* unitaire : int list list -> int
    - si `clauses' contient au moins une clause unitaire, retourne
      le littéral de cette clause unitaire ;
    - sinon, lève une exception `Not_found' *)
let unitaire clauses =
  (* Récupère toutes les clauses unitaires de `clauses`. *)
  let clauses_unitaires = List.filter (fun clause -> length clause = 1 ) clauses in
  (* Si la taille de `clauses_unitaires` est 0 alors il n'y a pas de clause unitaire,
     sinon on renvoit le litteral de la première clause unitaire trouvé. *)
  if length clauses_unitaires = 0 then raise Not_found else hd (hd clauses_unitaires)

(* tests *)
(* let () = print_string("unitaire \n") *)
(* let () = print_clauses exemple_7_2 *)
(* let () = print_int (unitaire exemple_7_2) *)
(* let () = print_string("\n") *)
(* let () = print_clauses exemple_7_4 *)
(* let () = print_int (unitaire exemple_7_4) *)
(* let () = print_string("\n") *)
(* let () = print_clauses exemple_7_8 *)
(* let () = print_clauses ([[1;2;3];[];[4]]) *)
(* let () = print_int (unitaire [[1;2;3];[];[4]]) *)
(* let () = print_string("\n") *)
(* let () = print_clauses ([[1;2;3];[6];[4;2];[1]]) *)
(* let () = print_int (unitaire [[1;2;3];[6];[4;2];[1]]) *)
(* let () = print_string("\n")    *)

(* pur : int list list -> int
    - si `clauses' contient au moins un littéral pur, retourne
      ce littéral ;
    - sinon, lève une exception `Failure "pas de littéral pur"' *)
let rec pur = function
  (* Pas de littéral pur. *)
  | [] -> raise (Failure "pas de littéral pur")
  | clause :: clauses_restantes ->
      match clause with
      | l :: litteraux_restants ->
        (* Récupère le premier littéral l de `clause`. *)
        let l = hd clause in
        (* Si il l n'est pas pur, *)
        if List.exists (fun c -> mem (-l) c) (litteraux_restants :: clauses_restantes) then
          (* essaie un nouvel littéral de la clause après avoir supprimé l et -l. *)
          pur (
            List.map (fun c -> List.filter (fun l' -> -l <> l' && l <> l') c)
            (litteraux_restants :: clauses_restantes)
          )
        else l
      (* Tous les littéraux de la clause courrante ont été testés. *)
      | [] -> pur clauses_restantes

(* solveur_dpll_rec : int list list -> int list -> int list option *)
let rec solveur_dpll_rec clauses interpretation =
  (* Si il n'y plus de clause alors `clauses` est satisfaisable*)
  if clauses = [] then Some interpretation else
  (* Si `clauses` contient une clause vide alors `clauses` est insatisfaisable. *)
  if mem [] clauses then None else
  let l_unit = try Some (unitaire clauses) with Not_found -> None in
  let l_pur  = try Some (pur clauses) with Failure (e) -> None in
  match l_unit, l_pur  with
  (* Si `clauses` contient un littéral unitaire `l_unit` simplifie `clauses` par `l_unit`
     avant de rappeller récurssivement dpll. *)
  | Some l_unit, _  -> solveur_dpll_rec (simplifie l_unit clauses) (l_unit :: interpretation)
  (* Si `clauses` contient un littéral pur `l_pur` simplifie `clauses` par `l_pur`
     avant de rappeller récurssivement dpll. *)
  | _, Some l_pur   -> solveur_dpll_rec (simplifie l_pur clauses) (l_pur :: interpretation)
  | _               ->
      (* Sinon on essaie de simplifier par `l`. *)
      let l = hd (hd clauses) in
      match solveur_dpll_rec (simplifie l clauses) (l :: interpretation) with
      (* Si la branche mène à une interprétation qui ne satisfait pas `clauses`
         on essaie de simplifier par `-l`. *)
      | None            -> solveur_dpll_rec (simplifie (-l) clauses) ((-l) :: interpretation)
      | Some interpret  -> Some interpret

(* tests *)
(* let () = print_int (pur exemple_7_4) *)
(* let () = print_int (pur [[2];[-1;-2];[1;-3];[-3];[-1;-2]]) *)
(* let () = print_modele (solveur_dpll_rec systeme []) *)
(* let () = print_modele (solveur_dpll_rec dependances []) *)
(* let () = print_modele (solveur_dpll_rec coloriage []) *)
(* let () = print_modele (solveur_split systeme []) *)
(* let () = print_modele (solveur_split dependances []) *)
(* let () = print_modele (solveur_split coloriage []) *)

let () =
  let clauses = Dimacs.parse Sys.argv.(1) in
  print_modele (solveur_dpll_rec clauses [])
