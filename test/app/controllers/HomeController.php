<?php

class HomeController extends BaseController {
public $board; 
public $turn;

	public function __construct () {	
		$this->board = json_decode(Cache::get('board'), 1);
		$this->turn = Cache::get('turn');
		if (empty($this->turn)) {
			$this->turn = 1;
		}
	}
	
	public function listing() {
		return View::make ('login');
	}

	public function resetgame () {
		$this->board = array();
		for ($x=0; $x<10;$x++) {
			for ($y=0; $y<10;$y++) {
				$this->board[$x][$y] = 0;
			 }
		}
		$this->turn = 1;
		$this->saveBoard();
		return Redirect::to('connectfour');
	}
	
	public function login () {
		$user = Input::get('user');
		Session::put('user', $user);
		return Redirect::to('connectfour/play');
	}
	
	public function play () {
		$session = Session::all();
		$data = array();
		if (isset($session['user'])) {
			$data['user'] = $session['user'];
		}
		$data['board'] = $this->board;
		return View::make('board', $data);
	}
	
	public function saveBoard () {
		Cache::forever('board', json_encode($this->board));
	}
	
	public function makemove() {
		$resData['message']="";
		$resData['error']="0";
		$user = Input::get('user');
		if ($user != $this->turn) {
			$resData['error'] 	= 1;
			$resData['message'] = 'wait for User ' . $this->turn . ' move';
		}
		$y = Input::get('yVal');
		$next = false;
		$x = 9;
		if ($resData['error'] == 0) {
			while ($next === false && $x>=0) {
				$this->board[$x][$y];
				if ($this->board[$x][$y] == 0) {
					$this->board[$x][$y] = $this->turn;
					$next = $x;
				}
				$x--;
			}
			if ($next === false) {
				$resData['error'] =1;
				$resData['message'] = "cant make this move x: " . Input::get("xVal") . " y: $y";
			} else {
				$resData['next'] = $next;
				$this->turn = ($this->turn==1)?2:1;
				$this->saveBoard();
				Cache::forever('turn', $this->turn);
				$resData['message'] = "you played x: " . ($next) ." y: $y";
			}
			$resData["board"] = $this->board;
		}	
		$resData['winner'] = 0;
		if ($res = $this->checkWinnerVer(1)) {
			$resData['winner'] = "User 1 with " . $res;
		} elseif ($res = $this->checkWinnerVer (2)) {
			$resData['winner'] = "User 2 with " . $res;
		} elseif ($res = $this->checkWinnerHor (1)) {
			$resData['winner'] = "User 1 with " . $res;
		} elseif ($res = $this->checkWinnerHor (2)) {
			$resData['winner'] = "User 2 with " . $res;
		}
		echo json_encode ($resData);
	}
	
	public function checkWinnerHor ($user) {
		$winner = 0;
			for ($x=0;$x<=9;$x++) {
				for ($y = 0; $y<5; $y++) {
					$col = $y;
					if ($this->board[$x][$col++] == $user &&  
						$this->board[$x][$col++] == $user &&  
						$this->board[$x][$col++] == $user &&  
						$this->board[$x][$col++] == $user){
						$winner = "x: $x from $y to " . ($col-1);
					}
				}
			}
		return $winner;
	}
	public function checkWinnerVer ($user) {
		$winner = 0;
			for ($y=0;$y<=9;$y++) {
				for ($x = 0; $x<=5; $x++) {
					$row = $x;
					if ($this->board[$row++][$y] == $user &&  
						$this->board[$row++][$y] == $user &&  
						$this->board[$row++][$y] == $user &&  
						$this->board[$row++][$y] == $user){
						$winner = "col: $y from $x to " . ($row-1);
					}
				}
			}
		return $winner;
	}
}
