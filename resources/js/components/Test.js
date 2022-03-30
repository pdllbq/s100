import React from 'react';
import ReactDOM from 'react-dom';

const Test = () =>
{
	return (
		<div>Hello world</div>
	)
}

export default Test;


document.addEventListener("DOMContentLoaded", function() {
	if (document.getElementById('test-react')) {
	    ReactDOM.render(<Test />, document.getElementById('test-react'));
	}
});
