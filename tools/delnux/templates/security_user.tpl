
		if (!$this->user->isAuthenticated()) {
			return WidgetHelper::message_session();
		}
