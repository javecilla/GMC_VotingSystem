<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthLayout extends Component {
	public $title;

	public function __construct($title = null) {
		$this->title = $title;
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View | Closure | string {
		return view('components.layout.auth');
	}
}
