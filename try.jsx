import React, { useState, useEffect } from "react";
import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { AlertCircle, Bell, FileText } from "lucide-react";
import { LineChart, Line, XAxis, YAxis, Tooltip, ResponsiveContainer } from "recharts";

const WaterQualityDashboard = () => {
  const [waterQuality, setWaterQuality] = useState([]);
  const [alerts, setAlerts] = useState([]);
  const [reports, setReports] = useState([]);

  useEffect(() => {
    const fetchWaterData = async () => {
      const response = await fetch("/api/water-quality");
      const data = await response.json();
      setWaterQuality(data);
      checkThreshold(data);
    };
    
    fetchWaterData();
    const interval = setInterval(fetchWaterData, 5000);
    return () => clearInterval(interval);
  }, []);

  const checkThreshold = (data) => {
    const threshold = 50; 
    const alertsList = data.filter((entry) => entry.quality < threshold);
    if (alertsList.length > 0) {
      setAlerts(alertsList);
      alert("Warning: Water quality is below safe levels!");
    }
  };

  const generateReport = () => {
    const highestContaminationDays = waterQuality.filter((entry) => entry.quality < 50);
    setReports(highestContaminationDays);
  };

  return (
    <div className="p-4 grid gap-4">
      <h1 className="text-2xl font-bold">Water Quality Monitoring System</h1>
      <div className="grid md:grid-cols-2 gap-4">
        <Card>
          <CardContent>
            <h2 className="text-xl font-semibold flex items-center gap-2">
              <Bell /> Real-time Alerts
            </h2>
            {alerts.length > 0 ? (
              alerts.map((alert, index) => (
                <p key={index} className="text-red-600 flex items-center gap-2">
                  <AlertCircle /> Alert! Water quality at {alert.location} is below safe levels.
                </p>
              ))
            ) : (
              <p>No current alerts.</p>
            )}
          </CardContent>
        </Card>

        <Card>
          <CardContent>
            <h2 className="text-xl font-semibold flex items-center gap-2">
              <FileText /> Reports
            </h2>
            <Button onClick={generateReport} className="mt-2">Generate Report</Button>
            {reports.length > 0 && (
              <ul className="mt-2">
                {reports.map((report, index) => (
                  <li key={index} className="text-gray-700">
                    {report.date}: High contamination at {report.location}
                  </li>
                ))}
              </ul>
            )}
          </CardContent>
        </Card>
      </div>

      <Card>
        <CardContent>
          <h2 className="text-xl font-semibold">Water Quality Data</h2>
          <ResponsiveContainer width="100%" height={300}>
            <LineChart data={waterQuality}>
              <XAxis dataKey="date" />
              <YAxis domain={[0, 100]} />
              <Tooltip />
              <Line type="monotone" dataKey="quality" stroke="#007bff" />
            </LineChart>
          </ResponsiveContainer>
        </CardContent>
      </Card>
    </div>
  );
};

export default WaterQualityDashboard;
