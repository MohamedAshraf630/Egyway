import axios from "axios";
import { useEffect, useState } from "react";

export const Search = () => {
  // useState is to manage re-renders when a state changes automatically
  const [airports, setAirports] = useState([]);
  const [arrivalFlights, setArrivalFlights] = useState([]);
  const [deptFlights, setDeptFlights] = useState([]);

  const [leavingFrom, setLeavingFrom] = useState("");
  const [goingTo, setGoingTo] = useState("");
  const [dateFrom, setDateFrom] = useState("");
  const [dateTo, setDateTo] = useState("");

  //Eventhandler according to the state
  useEffect(() => {
    //axios is used To get data from the server
    axios
      .get("http://localhost/egyway/services/react/get-airports-dropdown.php")
      .then((response) => {
        setAirports(response.data);
      });
  }, []);

  const handleSubmit = (e) => {
    const data = { leavingFrom, goingTo, dateFrom, dateTo };
    axios
      .post("http://localhost/egyway/services/react/post-flights.php", data)
      .then((response) => {
        setArrivalFlights(response.data?.arrival_flights);
        setDeptFlights(response.data?.dept_flights);
        // The flights coming from the server
      });
    e.preventDefault();
  };

  const onLeavingFromChange = (e) => {
    setLeavingFrom(e.target.value);
  };

  const onGoingToChange = (e) => {
    setGoingTo(e.target.value);
  };

  const onDateFromChange = (e) => {
    setDateFrom(e.target.value);
  };

  const onDateToChange = (e) => {
    setDateTo(e.target.value);
  };

  return (
    <div className="container mt-5">
      <div className="card p-3">
        <h3>Inquiry for available flights</h3>
        <form onSubmit={handleSubmit}>
          <div className="row">
            <div className="col-3">
              <label>Leaving From</label>
              <select
                className="form-control"
                onChange={onLeavingFromChange}
                value={leavingFrom}
              >
                <option>Select...</option>
                {airports.map((airport) => {
                  return <option value={airport.value}>{airport.label}</option>;
                })}
              </select>
            </div>
            <div className="col-3">
              <label>Going To</label>
              <select
                className="form-control"
                onChange={onGoingToChange}
                value={goingTo}
              >
                <option>Select...</option>
                {airports.map((airport) => {
                  return <option value={airport.value}>{airport.label}</option>;
                })}
              </select>
            </div>
            <div className="col-3">
              <label>Departing</label>
              <input
                type="date"
                className="form-control"
                onChange={onDateFromChange}
                value={dateFrom}
              />
            </div>
            <div className="col-3">
              <label>Returning</label>
              <input
                type="date"
                className="form-control"
                onChange={onDateToChange}
                value={dateTo}
              />
            </div>
            <div className="col-12">
              <button className="btn btn-success float-right">Inquiry</button>
            </div>
          </div>
        </form>
      </div>
      {deptFlights.length > 0 && arrivalFlights.length > 0 && (
        <>
          <div className="row mt-2">
            <div className="col-12">
              <h4>Search Results</h4>
            </div>
          </div>
          <h5>Departure Flights</h5>
          <div className="row">
            {deptFlights.map((flight) => {
              return (
                <div class="col-12 mt-2">
                  <div class="card">
                    <div class="card-body">
                      <h4>{flight.plane_no} </h4>
                      <b>
                        Departure: {flight.dept_date} - Arrival:{" "}
                        {flight.arrival_date}
                      </b>
                      <div>{flight.price} EGP</div>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
          <h5>Return Flights</h5>
          <div className="row">
            {arrivalFlights.map((flight) => {
              return (
                <div class="col-12 mt-2">
                  <div class="card">
                    <div class="card-body">
                      <h4>{flight.plane_no} </h4>
                      <b>
                        Departure: {flight.dept_date} - Arrival:{" "}
                        {flight.arrival_date}
                      </b>
                      <div>{flight.price} EGP</div>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
          <a href="http://localhost/egyway" className="btn btn-success btn-block mt-4">Book Your Flights</a>
        </>
      )}
    </div>
  );
};
