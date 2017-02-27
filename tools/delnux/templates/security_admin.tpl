
		if (!$this->user->isAdmin()) {
			return WidgetHelper::message_session();
		}
