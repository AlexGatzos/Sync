import logo from './image/ilopoiisi.png';
import profile from './image/profile.png';
// import customer from './image/customer.jpg';
// import order from './image/order.jpg';
// import product from './image/product.jpg';
import pr from './image/customer.jpg'
import prr from './image/1.jpg'
import prrr from './image/5.jpg'
import './App.css';
import React, { useState, createRoot, useEffect, useRef } from 'react';
import * as ReactDOM from 'react-dom/client';
import axios from 'axios';


function myFunction(id) {
  const element = document.getElementById(id);
  element.scrollIntoView();
}

const Logo = () => {
  return (
    <a href='https://www.ilopoiisi.gr/services/' target='_blank' rel="noreferrer" className="w-60 h-24 bg-zinc-50 flex mb-4 font-medium rounded-t-2xl rounded-e-2xl text-gray-900 title-font md:mb-0">
      <div>
        <img className=' rounded-lg ' src={logo} alt="ΥΛΟΠΟΙΗΣΗ" />
        {/* <h3 className="text-orange-600 text-3xl leading-6 tracking-wider font-bangers">ΥΛΟΠΟΙΗΣΗ</h3>
        <p className="text-xs ml-0 text-blue-800 font-normal capitalize italic relative font-mansalva">ΕΤΑΙΡΙΑ ΛΥΣΕΙΣ ΜΗΧΑΝΟΓΡΑΦΗΣΗΣ</p> */}
      </div>
    </a>
  );
};

// NavLink component
const NavLink = ({ href, children, onClick }) => {
  return (
    <a href={href} className=" mr-5 font-medium hover:text-orange-600" onClick={onClick}>
      {children}
    </a>
  );
};

const Navigation = ({ onContactClick, onHomeClick }) => {
  return (
    <nav className="flex flex-wrap items-center justify-center  text-lg md:ml-auto md:mr-auto">
      <NavLink href="http://localhost:3000/" onClick={() => myFunction('home')}>Home</NavLink>
      <NavLink href="#" onClick={() => myFunction('faq')}>FAQ</NavLink>
      <NavLink href="#" onClick={() => myFunction('contact')}>Contact</NavLink>
    </nav>
  );
};

// UserActions component
const UserActions = ({ onLoginClick }) => {
  return (
    <div className="w-60 pl-[134px] right- text-lg flex items-center h-full">
      <NavLink href="#_" onClick={() => onLoginClick()}>
        Login
      </NavLink>
      <Profile />
    </div>
  );
};
//Profile Menu component
const Profile = () => {
  // Handler hook for when Outside click dropdown close
  let useClickOutside = (handler) => {
    let domNode = useRef();

    useEffect(() => {
      let maybeHandler = (event) => {
        if (!domNode.current.contains(event.target)) {
          handler();
        }
      };

      document.addEventListener("mousedown", maybeHandler);

      return () => {
        document.removeEventListener("mousedown", maybeHandler);
      };
    });

    return domNode;
  };
  // Handler hook for when Outside click dropdown close End Code====>>


  const [dropdownOpen, setDropdownOpen] = useState(false);

  let domNode = useClickOutside(() => {
    setDropdownOpen(false);
  });

  return (
    <>
      {/* <!-- ====== Dropdowns Section Start --> */}
      <section class=" items-center dark:bg-dark">
        <div className="container">
          <div className="flex flex-wrap">
            {/* one */}
            <div ref={domNode} className="w-full ">
              <div className=" text-center">
                <div className="relative inline-block  text-left">
                  <button
                    onClick={() => setDropdownOpen(!dropdownOpen)}
                    className={` bg-primary flex items-center rounded-[5px]  py-[13px] text-base font-medium text-white`}
                  >
                    <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown"
                      data-dropdown-placement="bottom-start" className="flex  h-10 rounded-full outline-none ease"
                      src={profile} alt="User dropdown" />
                    <span className="">
                      {/* <svg
                        width={20}
                        height={20}
                        viewBox="0 0 20 20"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        className="fill-current"
                      >
                        <path d="M10 14.25C9.8125 14.25 9.65625 14.1875 9.5 14.0625L2.3125 7C2.03125 6.71875 2.03125 6.28125 2.3125 6C2.59375 5.71875 3.03125 5.71875 3.3125 6L10 12.5312L16.6875 5.9375C16.9688 5.65625 17.4063 5.65625 17.6875 5.9375C17.9687 6.21875 17.9687 6.65625 17.6875 6.9375L10.5 14C10.3437 14.1563 10.1875 14.25 10 14.25Z" />
                      </svg> */}
                    </span>
                  </button>
                  <div
                    className={` shadow-1 dark:shadow-box-dark absolute right-0 z-40 mt-2  rounded-2xl bg-orange-400 bg-opacity-90 dark:bg-dark-2 py-[10px] transition-all ${dropdownOpen
                      ? "top-full opacity-100 visible"
                      : "top-[110%] invisible opacity-0"
                      }`}
                  >
                    <DropdownItem label="Dashboard" href="/#" />
                    <DropdownItem label="Preview" href="/#" />
                    <DropdownItem label="Button" href="/#" />
                    <DropdownItem label="Subscribe" href="/#" />
                  </div>
                </div>
              </div>
            </div>
            {/* End */}
          </div>
        </div>
      </section>
      {/* <!-- ====== Dropdowns Section End -->    */}
    </>
  );
};
const DropdownItem = ({ label, href }) => {
  return (
    <a
      href={href}
      className=" rounded-lg text-body-color dark:text-dark-6 hover:bg-[#dce4fc] dark:hover:bg-primary/5 hover:text-primary block mx-2 px-5 py-2 text-base"
    >
      {label}
    </a>
  );
};
// Syxronismos Card component
const Portfolio = () => {
  const [showCard, setShowCard] = useState("all");

  const handleProject = (category) => {
    setShowCard(category);
  };

  return (
    <>
      <section className="  dark:bg-dark">
        <div className="container mx-auto">
          <div className=" flex flex-wrap ">
            <div className="w-full px-4">
              <div className=" mx-auto my-[3%] max-w-[510px] text-center">
                <h2 className=" text-cyan-950 mb-3 text-3xl leading-[1.208] font-bold sm:text-4xl md:text-[40px]">
                  Συγχρονισμός
                </h2>
                <p className="text-cyan-900 text-body-color text-base dark:text-dark-6">
                  Συγχρονίστε προϊόντα, κατηγορίες ή παραγγελίες με άμεση ενημέρωση μέσω απλής διαδικασίας.
                </p>
              </div>
            </div>
          </div>
          <div className=" flex flex-wrap justify-center">
            <PortfolioCard
              ImageHref={pr}
              category="Συγχρονισμός"
              title="Παραγγελιών-Πελατών"
              button="Sync Now"
              buttonHref="./login.html"
              showCard={showCard}
            />
            <PortfolioCard
              ImageHref={prrr}
              category="Συγχρονισμός"
              title="Ειδών"
              button="Sync Now"
              buttonHref="http://192.168.4.194/"
              showCard={showCard}
            />
            <PortfolioCard
              ImageHref={prr}
              category="Συγχρονισμός"
              title="Κατηγοριών-Brands"
              button="Sync Now"
              buttonHref="http://192.168.4.194/"
              showCard={showCard}
            />
          </div>
        </div>
      </section>
    </>
  );
};

const PortfolioCard = ({
  showCard,
  category,
  ImageHref,
  title,
  button,
  buttonHref,
}) => {
  const [showSync, setshowSync] = useState(false)

  const handleSyncClick = () => {
    setshowSync(true)
  };
  useEffect(() => {
    const bar = ReactDOM.createRoot(document.getElementById('prog'));
    if (showSync) {
      bar.render(<SyncComponent />);
    }
  }, [showSync]);
  return (
    <>
      <div
        className={`w-full px-4 md:w-1/2 xl:w-[26%]  ${showCard === "all" || showCard === category.toLowerCase()
          ? "block"
          : "hidden"
          }`}
      >
        <div className="relative mb-12">
          <div className="overflow-hidden rounded-[10px]">
            <img src={ImageHref} alt="portfolio" className="w-full" />
          </div>
          <div className="text-cyan-800 xl:h-44 relative z-10 mx-7 -mt-20 rounded-lg bg-white  dark:bg-dark-2 py-[34px] px-3 text-center shadow-portfolio dark:shadow-box-dark">
            <span className="text-primary mb-2 block text-sm font-medium">
              {category}
            </span>
            <h3 className="text-dark dark:text-white mb-5 text-xl font-bold">{title}</h3>
            <div id='prog' className='py-1'>
              <a href={buttonHref} target='_blank' className='bg-cyan-900 hover:bg-orange-300 hover:text-cyan-800 text-orange-300 inline-block rounded-md border  py-[10px] px-7 text-sm font-medium transition'>
                {button}
              </a>
              {/* <button
              onClick={handleSyncClick}
              className="bg-cyan-900 hover:bg-orange-300 hover:text-cyan-800 text-orange-300 inline-block rounded-md border  py-[10px] px-7 text-sm font-medium transition "
            >
              {button}
            </button> */}
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

//Header Component
const Header = () => {
  return (
    <header className="mx-auto w-full mt-3 bg-gradient-to-r from-orange-400 to-blue-300 text-cyan-900 shadow-md  rounded-3xl border-orange-950 body-font">
      <HeaderContent />
    </header>
  );
};

const HeaderContent = () => {
  const [showForm, setShowForm] = useState(false);

  const handleButtonClick = () => {
    setShowForm(true);

  };

  const handleFormClose = () => {
    setShowForm(false);
  };

  useEffect(() => {
    const root = ReactDOM.createRoot(document.getElementById('roott'));

    if (showForm) {
      root.render(<LoginForm onClose={handleFormClose} />);
    }
  }, [showForm,]);

  return (
    <div className="container flex flex-col items-center justify-between px-6 mx-auto md:flex-row">
      <Logo />
      <Navigation />
      <UserActions onLoginClick={handleButtonClick} />
    </div>
  );
};

//Test LoginForm Component
const LoginForm = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');
  const [isLoggedIn, setIsLoggedIn] = useState(false);

  // useEffect(() => {
  //   // Καλέστε το PHP αρχείο για να λάβετε τα διαπιστευτήρια
  //   fetch('./getCredentials.php')
  //     .then(response => response.json())
  //     .then(credentials => {
  //       // Αντλήστε τα διαπιστευτήρια από την απόκριση
  //       const { PYL_API_USERNAME, PYL_API_PASSWORD } = credentials;
  //       // Ανανεώστε την κατάσταση του συστατικού με τα διαπιστευτήρια
  //       setUsername(PYL_API_USERNAME);
  //       console.log(username)
  //       setPassword(PYL_API_PASSWORD);
  //       console.log(password)
  //     })
  //     .catch(error => console.error('Error fetching credentials:', error));
  // }, []); // Ο δεύτερος παράμετρος είναι ένα άδειο πίνακα, ούτε ηλεκτρόνια σήμανση, ούτε το username/password αλλάζουν

  const handleSubmit = async (e) => {
    e.preventDefault();

    // Έλεγχος αν τα στοιχεία ταυτίζονται
    if (username === 'demo' && password === 'demo') {
      setMessage('Σύνδεση επιτυχής!');
      setIsLoggedIn(true);
      // Εδώ μπορείτε να εκτελέσετε άλλες ενέργειες που χρειάζεστε
    } else {
      setMessage('Λανθασμένο όνομα χρήστη ή κωδικός πρόσβασης!');
    }
    console.log(message);

  };

  return (

    <div className="pt-24 w-full max-w-xs mx-auto">

      <form method='post' className='bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 bg-opacity-90' onSubmit={handleSubmit}>
        <div className="mb-4">
          <label htmlFor="username" className="block text-cyan-800 text-sm font-bold mb-2">
            Username
          </label>
          <input
            name="username"
            required
            value={username}
            onChange={(e) => setUsername(e.target.value)}
            className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="username"
            type="text"
            placeholder="Username"
          />
        </div>
        <div className="mb-6">
          <label htmlFor="password" className="block text-cyan-800 text-sm font-bold mb-2">
            Password
          </label>
          <input
            name="password"
            required
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            className="shadow appearance-none border border-orange-400 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            id="password"
            type="password"
            placeholder="******************"
          />
          <p className="text-orange-400 text-xs italic">Please choose a password.</p>
        </div>
        <div className="flex items-center justify-between">
          <button

            className="bg-cyan-900 hover:bg-orange-300 hover:text-cyan-800 text-orange-300 inline-block rounded-md border  py-[10px] px-7 text-sm font-medium transition"
            type="submit"
          >
            Sign In
          </button>
          <a
            className="inline-block align-baseline font-bold text-sm text-orange-700 hover:text-orange-800"
            href="https://www.ilopoiisi.gr/services/"
          >
            Forgot Password?
          </a>
        </div>
      </form>
    </div>
  );
};

//LoginForm Component
// const LoginForm = ({ onClose }) => {
//   const [username, setUsername] = useState('');
//   const [password, setPassword] = useState('');

//   const handleSubmit = (e) => {
//     e.preventDefault();
//     // Προσθέστε τη λογική που χρειάζεται για την υποβολή της φόρμας
//     console.log('Username:', username);
//     console.log('Password:', password);
//   };

//   return (
//     <div className="pt-24 w-full max-w-xs mx-auto">
//       <form className='bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 bg-opacity-90' onSubmit={handleSubmit}>
//         <div className="mb-4">
//           <label htmlFor="username" className="block text-cyan-800 text-sm font-bold mb-2">
//             Username
//           </label>
//           <input
//             name="username"
//             required
//             value={username}
//             onChange={(e) => setUsername(e.target.value)}
//             className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
//             id="username"
//             type="text"
//             placeholder="Username"
//           />
//         </div>
//         <div className="mb-6">
//           <label htmlFor="password" className="block text-cyan-800 text-sm font-bold mb-2">
//             Password
//           </label>
//           <input
//             name="password"
//             required
//             value={password}
//             onChange={(e) => setPassword(e.target.value)}
//             className="shadow appearance-none border border-orange-400 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
//             id="password"
//             type="password"
//             placeholder="******************"
//           />
//           <p className="text-orange-400 text-xs italic">Please choose a password.</p>
//         </div>
//         <div className="flex items-center justify-between">
//           <button

//             className="bg-cyan-900 hover:bg-orange-300 hover:text-cyan-800 text-orange-300 inline-block rounded-md border  py-[10px] px-7 text-sm font-medium transition"
//             type="submit"
//           >
//             Sign In
//           </button>
//           <a
//             className="inline-block align-baseline font-bold text-sm text-orange-700 hover:text-orange-800"
//             href="https://www.ilopoiisi.gr/services/"
//           >
//             Forgot Password?
//           </a>
//         </div>
//       </form>
//     </div>
//   );
// };

//Contact Component
const ContactInfo = ({ icon, title, description, contactInfo }) => {
  return (
    <div className="flex flex-col items-center justify-center text-center">
      <span className="p-3 text-orange-700 rounded-full bg-cyan-100/80 dark:bg-gray-800">
        {icon}
      </span>

      <h2 className="mt-4 text-lg font-medium text-cyan-900 dark:text-white">{title}</h2>
      <p className="mt-2 text-cyan-700 dark:text-gray-400">{description}</p>
      <p className="select-all mt-2 text-orange-700 dark:text-cyan-400">{contactInfo}</p>
    </div>
  );
};

const ContactSection = () => {
  return (
    <section className="my-24  bg-white bg-opacity-40 rounded-full dark:bg-gray-900">
      <div id='contact' className="container px-6 py-12 mx-auto">
        <div className="text-center">
          <p className="font-medium text-orange-700 dark:text-blue-400">Contact us</p>
          <h1 className="mt-2 text-2xl font-semibold text-cyan-900 md:text-3xl dark:text-white">Ας έρθουμε σε επαφή</h1>
          <p className="mt-3 text-cyan-900 dark:text-gray-400">Η ομάδα μας είναι πάντα εδώ για να συνομιλήσει.</p>
        </div>

        <div className="grid grid-cols-1 gap-12 mt-10 md:grid-cols-2 lg:grid-cols-3">
          <ContactInfo
            icon={
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" className="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
              </svg>
            }
            title="Email"
            description="Η ομάδα μας είναι εδώ για να βοηθήσει."
            contactInfo="info@ilopoiisi.gr"
          />

          <ContactInfo
            icon={
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" className="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
              </svg>
            }
            title="Office"
            description="Ελάτε να πείτε ένα γεια στα κεντρικά γραφεία μας."
            contactInfo="Διεύθυνση Κισσάμου 118, Χανιά"
          />

          <ContactInfo
            icon={
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" className="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
              </svg>
            }
            title="Phone"
            description="Δευ-Παρ από τις 9am έως τις 5pm."
            contactInfo="2821027223"
          />
        </div>
      </div>
    </section>
  );
};

const SyncComponent = () => {
  const [progress, setProgress] = useState(0);
  const [information, setInformation] = useState('Συγχρονισμός Ειδών. Παρακαλώ Περιμένετε...');

  // Function to perform synchronization
  const performSync = async () => {
    try {
      const response = await axios.get(); // Προσαρμόστε το URI του PHP script
      console.log(response.data); // Χειριστείτε τα δεδομένα απάντησης όπως χρειάζεται
    } catch (error) {
      console.error('Σφάλμα κατά τη διάρκεια του συγχρονισμού:', error);
    }
  };

  // useEffect to simulate synchronization progress
  useEffect(() => {
    const totalSteps = 4;

    const simulateSync = async () => {
      for (let step = 0; step < totalSteps; step++) {
        setProgress((step + 1) / totalSteps * 100);
        switch (step) {
          case 0:
            setInformation('Συγχρονισμός Ειδών. Παρακαλώ Περιμένετε...');
            break;
          case 1:
            setInformation('Συγχρονισμός Χαρακτηριστικών. Παρακαλώ Περιμένετε...');
            break;
          case 2:
            setInformation('Συγχρονισμός Φωτογραφιών Χαρακτηριστικών Ειδών. Παρακαλώ Περιμένετε...');
            break;
          case 3:
            setInformation('Ο Συγχρονισμός ολοκληρώθηκε! Τώρα μπορείτε να κλείσετε το παράθυρο.');
            break;
          default:
            break;
        }

        await new Promise(resolve => setTimeout(resolve, 1000)); // Προσομοίωση καθυστέρησης, προσαρμόστε ανάλογα
      }
    };

    simulateSync();
    performSync(); // Καλέστε τη συνάρτηση συγχρονισμού εδώ
  }, []);

  // Return the JSX for the component
  return (
    <div className="px-[20%]">
      {/* <h2 className='text-cyan-950 mb-3 text-3xl leading-[1.208] font-bold sm:text-4xl md:text-[40px]'>Συγχρονισμός Ειδών</h2>
      <h5 id="wait" className='text-cyan-900 text-body-color text-base dark:text-dark-6'>Μην κλείσετε το παράθυρο!</h5> */}
      <div class="mb-5 h-5 overflow-hidden rounded-full bg-gray-200 text-xs leading-none  text-center text-cyan-800">
        <div class="h-5 animate-pulse rounded-full bg-gradient-to-r from-orange-500 to-cyan-500 text-xs leading-none  text-center text-white pt-1" style={{ width: `${progress}%` }}>{progress}%</div>
      </div>
      {/* <div id="information" className='text-cyan-900 text-body-color text-base dark:text-dark-6 pb-14' style={{ fontSize: '130%' }}>{information}</div> */}
    </div>
  );
};

const FaqComponent = () => {
  return (

    <div class="container my-24 mx-auto md:px-6">
      <section class="">
        <div class="grid gap-4 md:grid-cols-2">
          <div class=" md:mb-0">
            <h2 class="text-cyan-950 mb-3 text-3xl leading-[1.208] font-bold sm:text-4xl md:text-[40px]">Συχνές ερωτήσεις</h2>

            <p class="text-cyan-900 text-body-color dark:text-dark-6 text-xl">
              Δεν βρήκατε την απάντησή σας στo <span className='text-orange-700 font-semibold'>FAQ</span>?
            </p>
            <p class="text-cyan-900 text-xl font-semibold">
              <a href="#!" onClick={() => myFunction('contact')}>
                Επικοινωνήστε με την ομάδα μας.</a>.
            </p>
          </div>

          <div class="mb-6 md:mb-0">
            <p class="text-cyan-950 mb-3 text-xl leading-[1.208] font-bold  ">Γιατί δεν συγχρονίζει το συγκεκριμένο προιόν;</p>
            <p class="mb-12 text-cyan-900 text-body-color text-lg dark:text-dark-6">
              Ελέγξτε προσεκτικά και βεβαιωθείτε ότι έχετε συμπληρώσει όλα τα απαραίτητα πεδία για το προϊόν, όπως το όνομα,
              η τιμή, η περιγραφή, και άλλες σχετικές πληροφορίες. Εξασφαλίστε ότι κανένα από αυτά τα πεδία δεν είναι κενό ή
              περιέχει ανακριβείς πληροφορίες.
              Η επιτυχία του συγχρονισμού εξαρτάται από την ορθή συμπλήρωση αυτών των πεδίων, επομένως, επανεξετάσετε τα
              δεδομένα πριν προχωρήσετε.
            </p>

            <p class="text-cyan-950 mb-3 text-xl leading-[1.208] font-bold">Γιατί δεν ολοκληρώνεται ο συγχρονισμός;</p>
            <p class="mb-12 text-cyan-900 text-body-color text-lg dark:text-dark-6">

              Μην ξεχνάτε ότι δεν πρέπει ο όγκος των προϊόντων να μην είναι μεγάλος, γιατί θα χαθεί η επικοινωνία με τον διακομιστή.
            </p>

            <p class="text-cyan-950 mb-3 text-xl leading-[1.208] font-bold">
              Praesentium voluptatibus temporibus consequatur non aspernatur?
            </p>
            <p class="mb-12 text-cyan-900 text-body-color text-lg dark:text-dark-6">
              Minima sunt at nulla tenetur, numquam unde quod modi magnam ab
              deserunt ipsam sint aliquid dolores libero repellendus cupiditate
              mollitia quidem dolorem.
            </p>
          </div>
        </div>
      </section>
    </div>

  );
}

const ScrollButton = () => {
  const [isVisible, setIsVisible] = useState(false);

  // To useEffect xrisimopoieitai gia na elegxei to scroll kathe stigmi
  useEffect(() => {
    const handleScroll = () => {
      // Se afto to paradeigma, to 100 einai to upsos pou prepei na kateveis prin emfanistei to kryfo button
      const scrollY = window.scrollY;
      if (scrollY > 100) {
        setIsVisible(true);
      } else {
        setIsVisible(false);
      }
    };

    // Event listener gia na akouei to scroll event
    window.addEventListener('scroll', handleScroll);

    // Cleanup gia na afairethei to event listener otan to component katastrefetai
    return () => {
      window.removeEventListener('scroll', handleScroll);
    };
  }, []); // [] gia na treksei mono mia fora stin arxi

  // To kryfo button tha emfanizetai mono an isVisible einai true
  return (
    <div>
      {isVisible && (
        <button class=" fixed z-50 bottom-10 right-10 p-4 border-0 w-14 h-14 rounded-full shadow-md bg-orange-500 hover:bg-orange-700 text-white text-lg font-semibold transition-colors duration-300" onClick={scrollToTop}>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
            <path d="M12 4l8 8h-6v8h-4v-8H4l8-8z" />
          </svg>
          <span class="sr-only">Go to top</span>
        </button>
      )}
    </div>
  );
};

// Synartisi pou tha kaleitai otan o xristis pataei to kryfo button
const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth' // Kanei to scroll smoothly
  });
};

//Main Function
export default function App() {


  return (
    <div id='home' className=" scroll-smooth">
      <header>
        <Header />
        <div id='roott' className='mx-12'>
          <Portfolio />
          <div id='faq'></div>
          <FaqComponent />
          <ContactSection />
          <ScrollButton />

        </div>

        <div id='progress'></div>
      </header>

    </div>
  );
}
