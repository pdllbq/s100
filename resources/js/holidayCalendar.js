//React holidays calendar
import React, { useState, useCallback } from 'react';
import ReactDOM from 'react-dom';
import { Calendar } from '@natscale/react-calendar';

function HolidayCalendar() {
  const [value, setValue] = useState();

  const onChange = useCallback(
    (value) => {
      setValue(value);
    },
    [setValue],
  );

  const isHighlight = useCallback((date) => {
      //return true;
  }, []);

  return (
    <div>
      <Calendar value={value} lockView isHighlight={isHighlight} onChange={onChange} />
      <Calendar value={value} lockView isHighlight={isHighlight} onChange={onChange} />
    </div>
  );
}

if (document.getElementById('react-holiday-calendar')) {
    ReactDOM.render(<HolidayCalendar />, document.getElementById('react-holiday-calendar'));
}