
    function send_log(firebase,company, service, status, msg) {
      

      const timestamp = new Date().toISOString();

      const path = `services/${company}/${service}`;
      firebase
        .database()
        .ref(path)
        .set({
          company,
          service,
          status,
          msg,
          lastRun: timestamp,
        })
        .then(() => {
          document.getElementById("result").innerText =
            "✅ Log sent successfully!";
        })
        .catch((error) => {
          document.getElementById("result").innerText =
            "❌ Error: " + error.message;
        });
    }
